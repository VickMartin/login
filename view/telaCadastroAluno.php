<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php"); // Redireciona para a página de login
    exit;
}

require_once '../model/DTO/UsuarioDTO.php';
require_once '../model/DAO/UsuarioDAO.php';
$cpf = $_GET['cpf'];


    $usuarioDAO = new UsuarioDAO();

    $responsavel = $usuarioDAO->buscarResponsavelPorCPF($cpf);

    if (empty($responsavel)) {
    echo "<script>
            alert('CPF não encontrado, verifique se digitou corretamente!');
            window.location.href = '../view/buscarPai.php';
          </script>";
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
    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="../css/casdastroAluno.css">
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
        <a href="formMeuperfil.php" class="sidebar-btn" onclick="showSection('perfil')">Meu Perfil</a>
        <a href="gerencia.php" class="sidebar-btn" onclick="showSection('gerencia')">Gerenciar Perfis</a>
        <a href="buscarPai.php" class="sidebar-btn">Cadastrar Alunos</a>
        <a href="formResponsavel.php" class="sidebar-btn" onclick="showSection('responsavelForm')">Cadastrar Responsável</a>
        <a href="professorForm.php" class="sidebar-btn">Cadastrar Professor</a>
        <a href="criarTurmas.php" class="sidebar-btn">Criar Turmas</a>
        <a href="turmas.php" class="sidebar-btn">Turmas</a>
    </div>

    <!-- Formulário de Cadastro de Aluno -->
    <div class="form-aluno">
        <fieldset class="fieldset-aluno">
            <h2>Cadastro de Aluno</h2>
            <p>Nome do responsável: <?php echo $responsavel['nome'] ?></p>
            <p>CPF do responsável: <?php echo $responsavel['cpf'] ?></p>
          

            <form action="../control/cadastrarAlunoControl.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_responsavel" value="<?php echo $responsavel['id_responsavel']?>">
                <input type="hidden" name="nome_mae" value="<?php echo $responsavel['nome']?>">

                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Nome do aluno(a)" required>

                <label for="ano_ingresso">Ano de Ingresso:</label>
                <input type="text" id="ano_ingresso" name="ano_ingresso" placeholder="Ano de Ingresso" required>

                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" required>

                <label for="tipo_sanguineo">Tipo Sanguíneo:</label>
                <select id="tipo_sanguineo" name="tipo_sanguineo" required>
                    <option value="">Selecione</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>

                <label for="deficiencia">Deficiência:</label>
                <input type="text" id="deficiencia" name="deficiencia" placeholder="Descreva se houver">

                <label for="alergia">Alergia:</label>
                <input type="text" id="alergia" name="alergia" placeholder="Descreva se houver">

                <label for="foto">Foto do aluno:</label><br>
                <input type="file" id="foto" name="foto_aluno" accept="image/*" required><br><br>

                <input type="submit" value="Cadastrar">
            </form>
        </fieldset>
    </div>
</body>

</html>
