<?php

require_once '../model/DAO/AdmDAO.php'; // Inclui a classe AdmDAO

session_start();

// Verifica se o usuário está logado como administrador
if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'administrador') {
    echo "<script>
        alert('Acesso não autorizado!');
        window.location.href = '../index.php';
    </script>";
    exit;
}

// Pega o id do usuario que será alterado
require_once '../model/DTO/UsuarioDTO.php';
require_once '../model/DAO/UsuarioDAO.php';

$id = $_GET['id'];

// Cria o objeto UsuarioDAO
$usuarioDAO = new UsuarioDAO();

// Busca os dados do usuário pelo ID
$usuario = $usuarioDAO->BuscarUsuarioPorId($id);

// echo"<pre>";
// var_dump($usuario);


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
    <link rel="stylesheet" href="../css/admGerencia.css">
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
        <a href="gerencia.php" class="sidebar-btn">Gerenciar Perfis</a>
        <a href="buscarPai.php" class="sidebar-btn">Cadastrar Alunos</a>
        <a href="formResponsavel.php" class="sidebar-btn">Cadastrar Responsável</a>
        <a href="professorForm.php" class="sidebar-btn">Cadastrar Professor</a>
        <a href="criarTurmas.php" class="sidebar-btn">Criar Turmas</a>
        <a href="turmas.php" class="sidebar-btn">Turmas</a>
    </div>

    <div class="container-Alterar">
        <fieldset class="alterar">
            <legend>Alterar Informações do Usuário</legend>
            <form action="../control/alterarUsuarioControl.php" method="POST">
                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">

                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>" required>

                <label for="email">Email:</label>
                <input type="text" name="email" value="<?php echo $usuario['email']; ?>" required>

                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" value="<?php echo $usuario['cpf']; ?>" required>

                <label for="senha">Senha:</label>
                <input type="password" name="senha" value="<?php echo $usuario['senha']; ?>" required>

                <label for="perfil">Perfil:</label>
                <input type="text" name="perfil" value="<?php echo $usuario['perfil']; ?>" required>
                <center><?php 
                // Verifica se o perfil do usuário é "Responsável"
                if ($usuario['perfil'] == 'responsavel') {
                    echo '<a href="alterarResponsavel.php?id_usuario=' . $usuario['id_usuario'] . '">Mais informações</a>';
                }
                ?></center>
                    
                            <center><input id="submit-input" type="submit" value="Alterar"></center>
            </form>
        </fieldset> 
    </div>   
</body>
</html>


