<?php
require_once '../model/DAO/UsuarioDAO.php';
// Inicia a sessão
session_start();

// Verifica se o professor está logado
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil'] !== 'professor') {
    echo "<script>alert('Acesso negado!'); window.location.href = '../index.php';</script>";
    exit;
}

$idUsuario = $_SESSION['id_usuario']; // ID do usuário logado

// Instancia o ProfessorDAO para buscar o ID do professor
$usuarioDAO = new UsuarioDAO();
$idProfessor = $usuarioDAO->buscarIdProfessorPorUsuario($idUsuario);

if (empty($idProfessor)) {
    echo "<script>alert('Nenhum professor encontrado para este usuário.'); window.location.href = '../index.php';</script>";
    exit;
}

$idProfessor = $idProfessor['id_professor']; // Extrai o ID do professor do resultado

// Verifica se o parâmetro 'matricula' foi passado na URL
if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    // Instancia o objeto AlunoDAO e tenta buscar o aluno pela matrícula
    require_once '../model/DAO/AlunoDAO.php';
    $alunoDAO = new AlunoDAO();
    $aluno = $alunoDAO->buscarAlunoPorId($matricula);

    // Verifica se o aluno foi encontrado
    if (!$aluno) {
        echo "<p>Aluno não encontrado.</p>";
        exit;
    }

    // Verifica se o aluno tem um responsável associado
    if (empty($aluno['id_responsavel'])) {
        echo "<p>Aluno não tem responsável associado.</p>";
        exit;
    }

    // Busca os dados do responsável (mãe) com o id_responsavel
    $usuarioDAO = new UsuarioDAO();
    $responsavel = $usuarioDAO->buscarResponsavelPorId($aluno['id_responsavel']);

    // Verifica se o responsável foi encontrado
    if (!$responsavel) {
        echo "<p>Responsável não encontrado.</p>";
        exit;
    }
} else {
    echo "<p>Matrícula do aluno não informada.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
    <link rel="stylesheet" href="../css/telaProfessor.css">
</head>
<body>
    <nav class="navbar" style="background-color: #3498db;">
        <div class="system-name">
            <h3 style="color:white;">Relatórios:</h3>
        </div>
        <a href="../control/logout.php" class="logout-button">Sair</a>
    </nav>
    <br>
    <div class="content-aluno">
    <div class="menu_professor">
        <a href="perfilAluno.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Informações Pessoais</a>
        <a href="Comunicados.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Comunicados</a>
        <a href="visualizarAtestados.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Visualizar atestados</a>
        <a href="listarTurmasProfessor.php?id_turma=<?php echo htmlspecialchars($aluno['id_turma']); ?>" class="sidebar-btn">Turma</a>
    </div>

    
        <div class="perfil-comunicados">
           <fieldset style="width: 90%; margin:auto;"> 
            <h2>Upload de Arquivos</h2>
            <!-- Formulário para upload de arquivos -->
            <form action="../control/registroControl.php" method="POST" enctype="multipart/form-data" class="upload-form">
                    <!-- Campo oculto para enviar o id_responsavel -->
                    <input type="hidden" name="id_responsavel" value="<?php echo htmlspecialchars($aluno['id_responsavel']); ?>">
                    <input type="hidden" name="matricula" value="<?php echo htmlspecialchars($aluno['matricula']); ?>">
                    <input type="hidden" id="data_atestado" name="data_atestado" value="<?php echo date('Y-m-d'); ?>">

                    <!-- Campos de Upload de Arquivos -->
                    <div class="upload-fields">
                        <label for="tipo_arquivo">Tipo de Arquivo:</label>
                        <select name="tipo_arquivo" required>
                            <option value="relatorio">Relatório</option>
                            <option value="notas">Notas</option>
                        </select>
                    </div>

                    <div class="upload-fields">
                        <label for="arquivo_pdf">Upload de PDF:</label>
                        <input type="file" name="arquivo_pdf" accept=".pdf" required>
                    </div>

                   
                        <center><button type="submit" class="input-relatorio">Enviar</button></center>
                    
                </form>

            </form>
            </fieldset>
        </div>
    </div>
</body>
</html>