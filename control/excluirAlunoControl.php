<?php
require_once '../model/DTO/AlunoDTO.php';
require_once '../model/DAO/AlunoDAO.php';

$id = $_GET['id']; // Obtém o ID do aluno a ser excluído

// Instancia a classe AlunoDAO, não UsuarioDAO
$alunoDAO = new AlunoDAO(); 

// Chama o método excluirAluno passando o ID do aluno
$sucesso = $alunoDAO->excluirAluno($id);

// Exibe um alerta e redireciona dependendo do sucesso ou falha da exclusão
if ($sucesso) {
    echo "<script>
             alert('Aluno Excluído com Sucesso!');
             window.location.href = '../view/gerencia.php';
          </script>";
} else {
    echo "<script>
             alert('Falha ao Excluir Aluno!');
             window.location.href = '../view/gerencia.php';
          </script>";
}
?>
