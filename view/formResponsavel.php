<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php"); // Redireciona para a página de login
    exit;
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
    <link rel="stylesheet" href="../css/admCadastros.css">
</head>

<body>
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
        <a href="formMeuperfil.php" class="sidebar-btn" onclick="showSection('perfil')">Meu Perfil</a>
        <a href="gerencia.php" class="sidebar-btn" onclick="showSection('gerencia')">Gerenciar Prefis</a>
        <a href="buscarPai.php" class="sidebar-btn">Cadastrar Alunos</a>
        <a href="formResponsavel.php" class="sidebar-btn" onclick="showSection('responsavelForm')">Cadastrar Responsável</a>
        <a href="professorForm.php" class="sidebar-btn" >Cadastrar Professor</a>
        <a href="criarTurmas.php" class="sidebar-btn" >Criar Turmas</a>
        <a href="turmas.php" class="sidebar-btn" >Turmas</a>


    </div>


    <div class="form-content">
        <fieldset>
            <h2>Cadastro de Responsável</h2>
            <form action="../control/cadastroUsuarioControl.php" method="POST">
                <input type="hidden" name="perfil" value="responsavel">
                <label for="nome-responsavel">Nome:</label>
                <input type="text" id="nome-responsavel" name="nome" placeholder="Nome do Responsável" required>
                <br>
                <label for="email-responsavel">Email:</label>
                <input type="email" id="email-responsavel" name="email" placeholder="Email" required>
                <br>
                <label for="telefone-responsavel">Telefone:</label>
                <input type="text" id="telefone-responsavel" name="telefone" placeholder="Telefone" required>
                <br>
                <label for="endereco-responsavel">Endereço:</label>
                <input type="text" id="endereco-responsavel" name="endereco" placeholder="Endereço" required>
                <br>
                <label for="cpf-responsavel">CPF:</label>
                <input type="text" id="cpf-responsavel" name="cpf" placeholder="CPF" required>
                <br>
                <label for="senha-responsavel">Senha:</label>
                <input type="password" id="senha-responsavel" name="senha" placeholder="Senha" required>
                <br>
                <input type="submit" value="Cadastrar">
            </form>
        </fieldset>
        </div>



   
</body>

</html>