<?php
require_once '../model/DAO/UsuarioDAO.php';
require_once '../model/DAO/AtestadoDAO.php';
// Inicia a sessão
session_start();

// Verifica se o professor está logado
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil'] !== 'professor') {
    echo "<script>alert('Acesso negado!'); window.location.href = '../index.php';</script>";
    exit;
}

$idUsuario = $_SESSION['id_usuario']; // ID do usuário logado

// Instancia o ProfessorDAO para buscar o ID do professor
$usuarioDAO = new UsuarioDAO();
$idProfessor = $usuarioDAO->buscarIdProfessorPorUsuario($idUsuario);

if (empty($idProfessor)) {
    echo "<script>alert('Nenhum professor encontrado para este usuário.'); window.location.href = '../index.php';</script>";
    exit;
}

$idProfessor = $idProfessor['id_professor']; // Extrai o ID do professor do resultado

// Verifica se o parâmetro 'matricula' foi passado na URL
if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    // Instancia o objeto AlunoDAO e tenta buscar o aluno pela matrícula
    require_once '../model/DAO/AlunoDAO.php';
    $alunoDAO = new AlunoDAO();
    $aluno = $alunoDAO->buscarAlunoPorId($matricula);

    // var_dump($aluno);

    // Verifica se o aluno foi encontrado
    if (!$aluno) {
        echo "<p>Aluno não encontrado.</p>";
        exit;
    }

    // Verifica se o aluno tem um responsável associado
    if (empty($aluno['id_responsavel'])) {
        echo "<p>Aluno não tem responsável associado.</p>";
        exit;
    }

    // Busca os dados do responsável (mãe) com o id_responsavel
    $usuarioDAO = new UsuarioDAO();
    $responsavel = $usuarioDAO->buscarResponsavelPorId($aluno['id_responsavel']);


    // Verifica se o responsável foi encontrado
    if (!$responsavel) {
        echo "<p>Responsável não encontrado.</p>";
        exit;
    }
} else {
    echo "<p>Matrícula do aluno não informada.</p>";
    exit;
}

    // Recupera os atestados do aluno
    $atestadoDAO = new AtestadoDAO();
    $atestados = $atestadoDAO->listarAtestadosPorAluno($matricula);

    // var_dump($atestados);







?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atestados do Aluno - EducaMentes</title>
    <link rel="stylesheet" href="../css/telaProfessor.css">
    
</head>
<body>
    <nav class="navbar" style="background-color: #3498db;">
        <div class="system-name">
            <h3 style="color: white;">Atestados do Aluno(a): <?php echo htmlspecialchars($aluno['nome']); ?></h3>
        </div>
        
        <a href="../control/logout.php" class="logout-button">Sair</a>
        
    </nav>
    <br>
    <div class="content-aluno">
    <div class="menu_professor">
    <a href="perfilAluno.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Informações Pessoais</a>
        <a href="relatorio.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Relatórios</a>
        <a href="Comunicados.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Comunicados</a>
        <a href="listarTurmasProfessor.php?id_turma=<?php echo htmlspecialchars($aluno['id_turma']); ?>" class="sidebar-btn">Turma</a>
    </div>

    
        <div class="perfil-container">
            <div>
                <h2>Atestados Registrados</h2>
                
                <?php foreach ($atestados as $atestado): ?>
                <div class="atestado">
                    <h3>Atestado ID: <?php echo htmlspecialchars($atestado['id_atestado']); ?></h3>
                    <p><strong>Imagem do Atestado:</strong></p>
                    <!-- Link para abrir a imagem em uma nova aba -->
                    <a href="../uploads/<?php echo htmlspecialchars($atestado['imagem_atestado']); ?>" target="_blank">
                        <img src="../uploads/<?php echo htmlspecialchars($atestado['imagem_atestado']); ?>" alt="Atestado" width="200">
                    </a>
                    <p><strong>Data do Atestado:</strong> <?php echo date('d/m/Y', strtotime($atestado['data_atestado'])); ?></p>
                    <p><strong>Responsável: </strong><?php echo htmlspecialchars($aluno['nome_mae']); ?></p>

                   
                </div>
                <hr>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</body>
</html>
