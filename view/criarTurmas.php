<?php
session_start();
if (isset($_SESSION['id_usuario'])) {
    $idAdm = $_SESSION['id_usuario'];
} else {
    // Redireciona para a página de login se a sessão não estiver definida
    header("Location: ../index.php");
    exit();
}

// Inclui os arquivos de controle
require_once '../control/listarProfessores.php';
require_once '../control/listarTurmas.php';





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
        <h1>Gerenciamento de Turmas</h1>

        <h2>Criar Nova Turma</h2>
        <form action="../control/controleTurmas.php" method="POST">
            <label for="nome_turma">Nome da Turma:</label>
            <input type="text" name="nome_turma" required>

            <label for="ano">Ano de criação da turma:</label>
            <input type="text" name="ano" required>

            <label for="turno">Turno:</label>
                <select name="turno" id="turno" required>
                    <option value="Matutino">Matutino</option>
                    <option value="Vespertino">Vespertino</option>
                   
                </select>
            

            <label for="professor_responsavel">Professor Responsável:</label>
            <select name="professor_responsavel" required>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $t): ?>
                        <option value="<?php echo $t['id_professor']; ?>"><?php echo $t['nome']; ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Nenhum professor encontrado</option>
                <?php endif; ?>
            </select>

            <input type="hidden" name="id_adm" value="<?php echo $idAdm; ?>">
            <center><input type="submit" name="criar_turma" value="Criar Turma"></center>
        </form>

        <h2>Turmas Criadas</h2>

        <table border="1">
            <thead>
                <tr>
                    <th>ID da Turma</th>
                    <th>Nome da Turma</th>
                    <th>Turno</th>
                    <th>Ano</th>
                    <th>Professor Responsável</th>
                    <th colspan="2">Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($turmas)): ?>
                    <?php foreach ($turmas as $turma): ?>
                        <tr>
                            <td><?php echo $turma['id_turma']; ?></td>
                            <td><?php echo $turma['nome_turma']; ?></td>
                            <td><?php echo $turma['turno']; ?></td>
                            <td><?php echo $turma['ano']; ?></td>
                            <td><?php echo $turma['nome_professor']; ?></td>
                            <td>
                            <center> <a href="../view/adicionarAluno.php?id=<?php echo $turma['id_turma']; ?>">
                                    <button class="btn-adiciona">Adicionar Alunos</button>
                                </a></center>
                            </td>
                            <td>
                                <!-- Link para excluir a turma, redireciona para o controlador -->
                               <center> <a href="../control/excluirTurmaControl.php?id_turma=<?php echo $turma['id_turma']; ?>">
                                    <button class="btn-excluir">Excluir</button> </center>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Nenhuma turma encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
