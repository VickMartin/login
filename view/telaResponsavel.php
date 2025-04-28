<?php
require_once '../model/DAO/UsuarioDAO.php';
require_once '../model/DAO/AlunoDAO.php';
session_start();

// Verifica se o usuário está logado e tem o perfil 'responsavel'
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil'] !== 'responsavel') {
    echo "<script>alert('Acesso negado!'); window.location.href = '../index.php';</script>";
    exit;
}

$idUsuario = $_SESSION['id_usuario']; // ID do usuário logado

$usuarioDAO = new UsuarioDAO();
$idRes = $usuarioDAO->buscarUsuarioPorId($idUsuario);

// var_dump($idRes);

// Instancia o UsuarioDAO e busca o ID do responsável
$usuarioDAO = new UsuarioDAO();
$idResponsavel = $usuarioDAO->buscarResponsavel($idUsuario);  // Obtém o responsável do banco

// var_dump($idUsuario);
// Verifica se o responsável foi encontrado
if (empty($idResponsavel)) {
    echo "<script>alert('Nenhum responsável encontrado para este usuário.'); window.location.href = '../index.php';</script>";
    exit;
}

// Extraímos o ID do responsável (supondo que a função buscarResponsavel retorna um array com o campo 'id_responsavel')
$idResponsavel = $idResponsavel['id_responsavel']; // Ajuste caso o nome do campo seja diferente

// Instancia o AlunoDAO e busca os filhos (alunos) associados ao responsável
$alunoDAO = new AlunoDAO();
$filhos = $alunoDAO->listarFilhosPorResponsavel($idResponsavel);  // Retorna todos os alunos (filhos) do responsável

// Verifica se há filhos (alunos) encontrados
if (empty($filhos)) {
    echo "<script>alert('Nenhum aluno encontrado para este responsável.'); window.location.href = '../index.php';</script>";
    exit;
}

// Se tudo estiver correto, podemos exibir os alunos (filhos)
// echo"<pre>";
// var_dump($filhos);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela do Responsável</title>
    <link rel="stylesheet" href="../css/telaResponsavel.css">
</head>
<body>
     <!-- Barra de navegação -->
     <nav class="navbar">
        <div class="system-name">
            <h3>Educa<span>Mentes</span></h3>
        </div>
        <a href="../control/logout.php" class="logout-button">Sair</a>
    </nav>

    <div class="content">
        <div class="content-turmasP">
    
        <h1 class="saudacao">Olá, <?php echo htmlspecialchars($idRes['nome']);?> qual criança deseja monitorar hoje?</h1>
    
            <?php if (!empty($filhos)): ?>
                <div class="turmas-container">
                    <?php foreach ($filhos as $f): ?>
                        <!-- Exibe cada turma como um botão -->
                        <a href="avisos.php?matricula=<?php echo htmlspecialchars($f['matricula']); ?>" 
                        class="turma-button">
                        <?php echo htmlspecialchars($f['nome']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Nenhum Aluno(a) encontrado!</p>
            <?php endif; ?>

    
        </div>
    </div>
</body>
</html>

