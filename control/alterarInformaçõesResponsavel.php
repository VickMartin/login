<?php

require_once '../model/DTO/UsuarioDTO.php';
require_once '../model/DAO/UsuarioDAO.php';

// Dados do formulário de cadastro
$usuario_id = $_POST['usuario_id'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];





// // Cria e configura o objeto DTO
$usuarioDTO = new UsuarioDTO();

$usuarioDTO->setId_usuario($usuario_id);
$usuarioDTO->setTelefone($telefone);
$usuarioDTO->setEndereco($endereco);

// echo "<pre>";
// var_dump($usuarioDTO);



$usuarioDAO = new UsuarioDAO();
$sucesso = $usuarioDAO->alterarInformaçãoResponsavel($usuarioDTO);

if ($sucesso) {
    echo "<script>
             alert('Alteração concluída!');
             window.location.href = '../view/gerencia.php';
          </script>";
} else {
    echo "<script>
             alert('Operação falhou!');
             window.location.href = '../view/gerencia.php';
          </script>";
}

