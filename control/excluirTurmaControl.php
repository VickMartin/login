<?php
// Recebe o ID da URL
require_once '../model/DAO/TurmaDAO.php';

// Verifica se o parâmetro 'id_turma' existe na URL e é numérico
if (isset($_GET['id_turma']) && is_numeric($_GET['id_turma'])) {
    $id_turma = (int)$_GET['id_turma']; // Converte para inteiro

    var_dump($id_turma);
    // Instancia o objeto da classe TurmaDAO
    $turmaDAO = new TurmaDAO();

    // Tenta excluir a turma
    $sucesso = $turmaDAO->excluirTurma($id_turma);

    if ($sucesso) {
        // Redireciona de volta para a página de gerenciamento de turmas com sucesso
        header("Location: ../view/criarTurmas.php");
        exit();
    } else {
        // Se falhar, exibe um alerta e redireciona de volta
        echo "<script>
                 alert('Falha ao Excluir Turma!');
                 window.location.href = '../view/criarTurmas.php';
              </script>";
    }
} else {
    // Caso o parâmetro não seja válido, exibe mensagem de erro
    echo "<script>
             alert('ID da Turma inválido!');
             window.location.href = '../view/criarTurmas.php';
          </script>";
}
