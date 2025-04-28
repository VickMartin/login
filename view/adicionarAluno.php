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
    <title>Pesquisar Aluno | EducaMentes</title>
    <link rel="stylesheet" href="../css/alunosTurma.css">
   
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
    <a href="formMeuperfil.php" class="sidebar-btn">Meu Perfil</a>
    <a href="gerencia.php" class="sidebar-btn">Gerenciar Perfis</a>
    <a href="buscarPai.php" class="sidebar-btn">Cadastrar Alunos</a>
    <a href="formResponsavel.php" class="sidebar-btn">Cadastrar Responsável</a>
    <a href="professorForm.php" class="sidebar-btn">Cadastrar Professor</a>
    <a href="criarTurmas.php" class="sidebar-btn">Criar Turmas</a>
    <a href="turmas.php" class="sidebar-btn">Turmas</a>
</div>

<!-- Conteúdo principal -->
<div class="contener">

<fieldset>
    <form method="POST" action="">
        <h1>Insira a Matrícula do Aluno(a)</h1>
        <input type="text" name="search_id" placeholder="Pesquisar Aluno(a)" />
        <button type="submit" name="search">Pesquisar</button>
    </form>

    <?php
    if (isset($_POST['search'])) {
        $search_id = isset($_POST['search_id']) ? $_POST['search_id'] : '';
        
        if (!empty($search_id)) {
            $conn = new mysqli('localhost', 'root', '', 'educamentes');
            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }
            
            $sql = "SELECT nome, matricula FROM aluno WHERE matricula = '$search_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Resultado da Pesquisa:</h2>";
                while ($row = $result->fetch_assoc()) {
                    $id_turma = isset($_GET['id']) ? $_GET['id'] : null;
                    if ($id_turma) {
                        echo '<form method="POST" action="../control/adicionarAlunoControl.php">';
                        echo '<input type="hidden" name="id_turma" value="' . $id_turma . '">';
                        echo '<input type="hidden" name="matricula_aluno" value="' . $row['matricula'] . '">';
                        echo '<input type="text" name="nome_aluno" value="' . $row['nome'] . '" required>';
                        echo '<button type="submit" name="inserir" value="inserir">Inserir</button>';
                        echo '</form>';
                        echo"<br> <br>";
                        echo '<form method="POST" action="../view/criarTurmas.php">';
                        echo '<button type="submit" name="cancelar">Cancelar</button>';
                        echo '</form>';
                    } else {
                        echo "ID da turma não encontrado.";
                    }
                }
            } else {
                echo "Nenhum aluno encontrado com esse ID.";
            }
        }
       
    }
    ?>
</fieldset>
</div>

</body>
</html>
