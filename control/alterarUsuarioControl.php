<?php

require_once '../model/DTO/UsuarioDTO.php';
require_once '../model/DAO/UsuarioDAO.php';

// Dados do formulário de cadastro
$id_usuario = $_POST['id_usuario'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$perfil = $_POST['perfil'];


//  var_dump($id_usuario,$nome,$email,$cpf,$senha,$perfil );

// // Cria e configura o objeto DTO
$usuarioDTO = new UsuarioDTO();

$usuarioDTO->setId_usuario($id_usuario);
$usuarioDTO->setNome($nome);
$usuarioDTO->setEmail($email);
$usuarioDTO->setCpf($cpf);
$usuarioDTO->setSenha($senha);
$usuarioDTO->setPerfil($perfil);

// echo "<pre>";
// var_dump($usuarioDTO);

$usuarioDAO = new UsuarioDAO();
$sucesso = $usuarioDAO->alterarUsuario($usuarioDTO);

if ($sucesso) {
    echo "<script>
             alert('Alteração concluída!');
             window.location.href = '../view/gerencia.php?id_usuario=" . urlencode($id_usuario) . "';
          </script>";
} else {
    echo "<script>
             alert('Operação falhou!');
             window.location.href = '../view/gerencia.php?id_usuario=" . urlencode($id_usuario) . "';
          </script>";
}



