<?php
// recebe o ID
//criar o UsuarioDAO que faz a operação
require_once '../model/DTO/UsuarioDTO.php';
require_once '../model/DAO/UsuarioDAO.php';

$id = $_GET['id'];

// var_dump($id);

$usuarioDAO = new UsuarioDAO();

$sucesso = $usuarioDAO->excluirUsuario($id);

if ($sucesso) {
    echo "<script>
             alert('Usuário Excluído com Sucesso!');
             window.location.href = '../view/gerencia.php';
          </script>";
} else {
    echo "<script>
             alert('Falha ao Excluir Usuário!');
             window.location.href = '../view/gerencia.php';
          </script>";
}


?>