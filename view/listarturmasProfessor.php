<?php
require_once '../model/DAO/TurmaDAO.php';
session_start();

// Verifica se o professor está logado
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil'] !== 'professor') {
    echo "<script>alert('Acesso negado!'); window.location.href = '../index.php';</script>";
    exit;
}

// Captura o ID da turma passado na URL
if (isset($_GET['id_turma'])) {
    $id_turma = $_GET['id_turma'];

    // Instancia o DAO de Turma e busca os alunos e a turma
    $turmaDAO = new TurmaDAO();
    $turma = $turmaDAO->listarAlunosETurma($id_turma);  // Deve retornar os alunos e os dados da turma

    // Verifica se foram encontrados dados para a turma
    if (empty($turma)) {
        echo "<p>Nenhum dado encontrado para a turma selecionada.</p>";
        exit;
    }
} else {
    echo "<p>ID da turma não informado.</p>";
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turmas do Professor</title>
    <link rel="stylesheet" href="../css/telaProfessor.css">
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
    <h1 class="page-title">Detalhes da Turma</h1>

        <?php if (!empty($turma)): ?>
            <!-- Exibe o nome da turma -->
            <div class="turma-info">
                <h2 class="turma-name"><?php echo htmlspecialchars($turma[0]['nome_turma']); ?></h2>
                <h4 class="turma-professor"><strong>Professor:</strong> <?php echo htmlspecialchars($turma[0]['nome_professor']); ?></h4>
            </div>

            <!-- Lista de alunos -->
            <div class="alunos-container">
                <h3 class="section-title">Alunos:</h3>
                <ul class="alunos-list">
                    <?php foreach ($turma as $aluno): ?>
                        <!-- Exibe os alunos -->
                        <li class="aluno-item">
                            <a href="perfilAluno.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="aluno-link">
                                <button class="btn-aluno"><?php echo htmlspecialchars($aluno['nome_aluno']); ?></button>
                            </a>
                        </li>
                       
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <p class="no-students-msg">Nenhum aluno encontrado para esta turma.</p>
        <?php endif; ?>
                <a href="telaProfessor.php">Voltar à tela inicial</a>
    </div>
</div>
</body>
</html>


