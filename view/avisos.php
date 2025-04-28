<?php

session_start();

// Verifica se o usuário está logado e tem o perfil 'responsavel'
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil'] !== 'responsavel') {
    echo "<script>alert('Acesso negado!'); window.location.href = '../index.php';</script>";
    exit;
}

require_once '../model/DAO/AlunoDAO.php';
// Verifica se a matrícula foi passada na URL
if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];
    
     // Instancia o objeto AlunoDAO e tenta buscar o aluno pelo ID (matrícula)
     $alunoDAO = new AlunoDAO();
     $aluno = $alunoDAO->buscarAlunoPorId($matricula);
 
     require_once '../model/DAO/MensagemDAO.php';
     $mensagemDAO = new MensagemDAO();
 
     // Busca as mensagens do aluno
     $mensagens = $mensagemDAO->buscarMensagensPorAluno($matricula);

      

     if (!empty($mensagens)) {


                // Pegando o ID do professor a partir da primeira mensagem
        $idProfessor = $mensagens[0]['id_professor'];  // Supondo que todas as mensagens têm o mesmo professor

        // Buscando o id_usuario do professor
        require_once '../model/DAO/UsuarioDAO.php';
        $usuarioDAO = new UsuarioDAO();
        $professor = $usuarioDAO->buscarIdusuarioPorIdprofessor($idProfessor);

        // var_dump($professor);

        $usuarioDAO = new UsuarioDAO();
        $prof = $usuarioDAO->buscarUsuarioPorId($professor['usuario_id']);

        // var_dump($prof);
    }

    
    

    



}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunicados</title>
    <link rel="stylesheet" href="../css/telaResponsavel.css">
</head>
<body>
    <nav class="navbar" style="background-color: #3498db;">
        <div class="system-name">
            <h3 style="color:white;">Mensagens Referentes ao Aluno(a): <?php echo htmlspecialchars($aluno['nome']); ?></h3>
        </div>
        <a href="../control/logout.php" class="logout-button">Sair</a>
    </nav>
    <br>
        <div class="content-aluno">
        <div class="menu_professor">
        <a href="perfilAlunoPai.php?matricula=<?php echo htmlspecialchars($matricula); ?>" class="sidebar-btn">Informações Pessoais do Aluno(a)</a>
        <a href="envioAtestado.php?matricula=<?php echo htmlspecialchars($matricula); ?>" class="sidebar-btn">Anexar Atestados</a>
        <a href="visualizarRelatorio.php?matricula=<?php echo htmlspecialchars($matricula); ?>" class="sidebar-btn">Relatório do Aluno(a)</a>
        <a href="../view/telaResponsavel.php" class="sidebar-btn">Voltar à Tela Principal</a>
        
    </div>

    
    <div class="container">
        <div class="relato-container">
         
            <div>
            <?php if (empty($mensagens)): ?>
                <p>Não há mensagens para este aluno.</p>
            <?php else: ?>
                <?php foreach ($mensagens as $mensagem): ?>
                    <div class="mensagem">
                        <h3><?php echo htmlspecialchars($mensagem['tipo_mensagem']); ?></h3>
                        <p><strong>Mensagem:</strong> <?php echo nl2br(htmlspecialchars($mensagem['mensagem'])); ?></p>
                        <p><strong>Remente(Professor): </strong><?php echo htmlspecialchars($prof['nome']); ?></p>
                        <p><strong>Data:</strong> <?php echo htmlspecialchars($mensagem['data_envio']); ?></p>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
