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
        <a href="buscarPai.php" class="sidebar-btn" onclick="showSection('alunoForm')">Cadastrar Alunos</a>
        <a href="formResponsavel.php" class="sidebar-btn" onclick="showSection('responsavelForm')">Cadastrar Responsável</a>
        <a href="professorForm.php" class="sidebar-btn" onclick="showSection('professorForm')">Cadastrar Professor</a>
        <a href="criarTurmas.php" class="sidebar-btn" >Criar Turmas</a>
        <a href="turmas.php" class="sidebar-btn" >Turmas</a>
        </div>

 

    
    

        <div class="form-content">
            <fieldset>
                <h2>Cadastro de Aluno</h2>
                <p>Digite o cpf do responsavel: </p>

                <form action="telaCadastroAluno.php">
                    <input type="text" name="cpf" placeholder="Ex: 123.456.789-12">
                    <input type="submit" value="buscar">
                </form>
            </fieldset>    
        </div>
    </div>



    

   
</body>

</html>