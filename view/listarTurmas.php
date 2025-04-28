<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php"); // Redireciona para a página de login
    exit;
}

    // Captura o ID da turma passado via URL
    if (isset($_GET['id'])) {
        $id_turma = $_GET['id'];
        //  var_dump($id_turma);
        
        // Exemplo: Use o ID da turma para fazer uma consulta no banco de dados e buscar os alunos e o professor da turma
        require '../model/DAO/TurmaDAO.php';
       
        $turmasDAO = new TurmaDAO();

        // Suponha que temos métodos para buscar alunos e professor pela turma
        $turmas = $turmasDAO->listarAlunosETurma($id_turma);

        // echo"<pre>";
        // var_dump($turmas);

           // Verifica se os dados da turma foram retornados
    if (!empty($turmas)) {
        // Definir os dados da turma e do professor a partir do primeiro aluno
        $nome_turma = $turmas[0]['nome_turma'];  // Nome da turma
        $nome_professor = $turmas[0]['nome_professor'];  // Nome do professor
    }
}
require_once '../model/DAO/AdmDAO.php';
// Obtém o email do administrador logado
$emailAdministrador = $_SESSION['usuario'];

// Cria uma instância de AdmDAO para buscar os dados do administrador
$admDAO = new AdmDAO();
$dadosAdministrador = $admDAO->buscarDadosAdministrador($emailAdministrador);

// Verifica se encontrou os dados do administrador
if ($dadosAdministrador) {
    $id_usuario = $dadosAdministrador['id_Adm'];
    $nome = $dadosAdministrador['nome'];
    $email = $dadosAdministrador['email'];
    $foto = $dadosAdministrador['foto'] ?? 'default.jpg';
} else {
    echo "<script>
        alert('Dados do administrador não encontrados.');
        window.location.href = '../view/formMeuperfil.php';
    </script>";
    exit;
}
    
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA | VM</title>
    <link rel="stylesheet" href="../css/admCriarTurmas.css">
</head>
<body>
    <a href="../control/logout.php">Logout</a>
    <!-- Barra de navegação -->
    <nav class="navbar">
        <div class="system-name">
            <h3>Educa<span>Mentes</span></h3>
        </div>
        <a href="../control/logout.php" class="logout-button">Sair</a>
    </nav>

    <!-- Guia lateral -->
    <div class="sidebar">
        
              <!-- Exibe o nome do administrador logado -->
              <div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-title">Administrador</span>
        <img src="../images/<?php echo htmlspecialchars($foto); ?>" alt="Foto de Perfil" class="admin-photo">
    </div>
    <div class="admin-card-body">
        <span>Olá, <strong><?php echo htmlspecialchars($nome); ?>!</strong></span>
    </div>
    </div>
<div class="menu-container">
            <h3 class="menu-text">Menu</h3>
        </div>
        <hr>
        <br>
        <a href="formMeuperfil.php" class="sidebar-btn">Meu Perfil</a>
        <a href="gerencia.php" class="sidebar-btn">Gerenciar Prefis</a>
        <a href="buscarPai.php" class="sidebar-btn">Cadastrar Alunos</a>
        <a href="formResponsavel.php" class="sidebar-btn">Cadastrar Responsável</a>
        <a href="professorForm.php" class="sidebar-btn">Cadastrar Professor</a>
        <a href="criarTurmas.php" class="sidebar-btn">Criar Turmas</a>
        <a href="turmas.php" class="sidebar-btn">Turmas</a>
    </div>
    
<div class="content">
    <div class="turmas">
    <?php if (!empty($turmas)): ?>
        <!-- Informações da turma e do professor -->
        <div class="turma-info">
            <h1>Turma: <?php echo htmlspecialchars($nome_turma); ?></h1>
            <h2>Professor: <?php echo htmlspecialchars($nome_professor); ?></h2>
        </div>

        <!-- Lista de alunos -->
        <h3>Alunos:</h3>
        <ul class="alunos-list">
            <?php foreach ($turmas as $turma): ?>
                <!-- Exibe os alunos -->
                <li><?php echo htmlspecialchars($turma['nome_aluno']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nenhum dado encontrado para a turma selecionada.</p>
    <?php endif; ?>
    </div>
</div>
</body>
</html>