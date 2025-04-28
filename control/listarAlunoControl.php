<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../model/DTO/AlunoDTO.php';
require_once '../model/DAO/AlunoDAO.php';

// Verifica se o administrador está logado
if (isset($_SESSION['id_usuario'])) {
    $idAdm = $_SESSION['id_usuario']; // ID do administrador logado

    $alunoDAO = new AlunoDAO();
    $alunos = $alunoDAO->listarAlunos();
    
    // echo "<pre>";
    // var_dump($alunos);
}
?>
