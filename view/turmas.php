<?php
    require '../model/DTO/TurmaDTO.php';
    require '../model/DAO/TurmaDAO.php';
    session_start();

    $id = $_SESSION['id_usuario'];

    if (!isset($_SESSION['usuario'])) {
        header("Location: ../index.php"); // Redireciona para a página de login
        exit;
    }
 
    $turmaDAO = new TurmaDAO();
    $sucesso = $turmaDAO->listarTurmas();

    // var_dump($sucesso);



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
    <h2>Minhas Turmas</h2>
        
        <?php if (!empty($sucesso)): ?>
            <?php foreach ($sucesso as $t): ?>
                <a href="listarTurmas.php?id=<?php echo $t['id_turma']; ?>">
                    <button class="btn_turmas"><?php echo htmlspecialchars($t['nome_turma']); ?> _ <?php echo htmlspecialchars($t['turno']); ?></button>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Você ainda não possui turmas cadastradas.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>