<?php
session_start();

// Verifica se o usuário está logado e tem o perfil 'responsavel'
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil'] !== 'responsavel') {
    echo "<script>alert('Acesso negado!'); window.location.href = '../index.php';</script>";
    exit;
}

require_once '../model/DAO/AlunoDAO.php';
require_once '../model/DAO/MensagemDAO.php';
require_once '../model/DAO/RegistrosDAO.php';
require_once '../model/DAO/UsuarioDAO.php';

// Verifica se a matrícula foi passada na URL
if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    // Busca o aluno, as mensagens e os relatórios
    $alunoDAO = new AlunoDAO();
    $aluno = $alunoDAO->buscarAlunoPorId($matricula);
    
    $mensagemDAO = new MensagemDAO();
    $mensagens = $mensagemDAO->buscarMensagensPorAluno($matricula);

    // Verifica se há mensagens
    if (!empty($mensagens)) {
        $idProfessor = $mensagens[0]['id_professor'];  // Supondo que todas as mensagens têm o mesmo professor

        $usuarioDAO = new UsuarioDAO();
        $professor = $usuarioDAO->buscarIdusuarioPorIdprofessor($idProfessor);
        $prof = $usuarioDAO->buscarUsuarioPorId($professor['usuario_id']);
    } else {
        $mensagemErro = "Não há mensagens para este aluno.";
    }

    // Recupera os relatórios do aluno
    $relatorioDAO = new RegistrosDAO();
    $relatorios = $relatorioDAO->listarRelatoriosPorAluno($matricula);

    // var_dump($relatorios);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios do Aluno - EducaMentes</title>
    <link rel="stylesheet" href="../css/telaResponsavel.css">
</head>
<body>

    <nav class="navbar" style="background-color: #3498db;">
            <div class="system-name">
                <h3 style="color:white;">Relatórios do Aluno(a): <?php echo htmlspecialchars($aluno['nome'])?></h3>
            </div>
            <a href="../control/logout.php" class="logout-button">Sair</a>
        </nav>
        <br>
    <div class="content-aluno">
    <br>
    <div class="menu_professor">
        <a href="perfilAlunoPai.php?matricula=<?php echo htmlspecialchars($matricula); ?>" class="sidebar-btn">Informações Pessoais do Aluno(a)</a>
        <a href="envioAtestado.php?matricula=<?php echo htmlspecialchars($matricula); ?>" class="sidebar-btn">Anexar Atestados</a>
        <a href="avisos.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Avisos</a>
        <a href="../view/telaResponsavel.php" class="sidebar-btn">Voltar à Tela Principal</a>
        
    </div>

    <div class="container">
        <div class="relato-container">
            <div>
                <h2>Relatórios Registrados</h2>
                
                <?php foreach ($relatorios as $relatorio): ?>
                <div class="relatorio <?php echo htmlspecialchars($relatorio['tipo_documento']); ?>">
                    <h3>Relatório ID: <?php echo htmlspecialchars($relatorio['id_registro']); ?></h3>
                    
                    <td class="nota-coluna">
                        <a href="../uploads/<?php echo htmlspecialchars($relatorio['documento']); ?>" target="_blank" class="btn btn-edit">
                            <?php echo $relatorio['tipo_documento'] == 'notas' ? 'Ver Notas' : 'Ver Relatório'; ?>
                        </a>
                    </td>
                    <p><strong>Data do Envio:</strong> <?php echo date('d/m/Y', strtotime($relatorio['datetime'])); ?></p>
                    <p><strong>Responsável: </strong><?php echo htmlspecialchars($aluno['nome_mae']); ?></p>
                </div>
                <hr>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</body>
</html>
