
<?php
require_once '../model/DTO/UsuarioDTO.php';
require_once '../model/DAO/UsuarioDAO.php';

$cpf = $_GET['cpf'];

$usuarioDAO = new UsuarioDAO();
$responsavel = $usuarioDAO->buscarResponsavelPorCPF($cpf);



if ($responsavel) {
    header('Location: ../view/telaAdm.php');
    exit; // Garante que o script pare aqui
}

?>
