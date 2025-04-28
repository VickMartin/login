<?php

require_once '../model/DAO/UsuarioDAO.php';
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
// Pega o valor do id_usuario da URL
if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];  // Armazena o id_usuario na variável
    
    // Certifique-se de que o id_usuario é válido
    if (!is_numeric($id_usuario)) {
        echo "ID do usuário inválido.";
        exit;  // Encerra o script se o id_usuario não for válido
    }
} else {
    echo "ID do usuário não fornecido.";
    exit;  // Encerra o script se não tiver id_usuario
}

// Instancia o DAO do usuário
$usuarioDAO = new UsuarioDAO();

// Recupera o usuário completo
$usuario = $usuarioDAO->BuscarUsuarioPorId($id_usuario);

// Verifica se o perfil do usuário é 'responsavel'
if ($usuario['perfil'] !== 'responsavel') {
    // Se o perfil não for 'responsavel', redireciona para outra página
    echo "<script>
        alert('Acesso negado: Este usuário não é responsável!');
        window.location.href = 'gerencia.php'; // Redireciona para a página de gerenciamento
    </script>";
    exit; // Impede que o código continue se o perfil não for "Responsável"
}

// Recupera as informações específicas do responsável
$informacoesResponsavel = $usuarioDAO->buscarResponsavelIdUse($id_usuario);

//  var_dump($informacoesResponsavel);


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
        <legend>Alterar Informações do Responsável</legend>
        <form action="../control/alterarInformaçõesResponsavel.php" method="POST">
            <input type="hidden" name="usuario_id" value="<?php echo $informacoesResponsavel['usuario_id']; ?>">

            <div class="form-group">
                <label for="nome">Nome:</label>
                <p id="nome"><?php echo $usuario['nome']; ?></p>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <p id="email"><?php echo $usuario['email']; ?></p>
            </div>

            <div class="form-group">
                <label for="cpf">CPF:</label>
                <p id="cpf"><?php echo $usuario['cpf']; ?></p>
            </div>

          
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" value="<?php echo $informacoesResponsavel['telefone']; ?>" required>
           

            
                <label for="endereco">Endereço:</label>
                <input type="text" name="endereco" value="<?php echo $informacoesResponsavel['endereco']; ?>" required>
           

            
                <center><input id="submit-input" type="submit" value="Alterar"></center>
                
            
        </form>
    </fieldset>
</div>

</body>
</html>



