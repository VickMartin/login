<?php
// Inicia a sessão, se não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../model/DAO/TurmaDAO.php';

// Verifica se o administrador está logado
if (isset($_SESSION['id_usuario']) && $_SESSION['perfil'] === 'administrador') {
    $idAdm = $_SESSION['id_usuario']; // ID do administrador logado

    // Cria uma instância de TurmaDAO para buscar as turmas associadas ao administrador
    $turmaDAO = new TurmaDAO();
    $turmas = $turmaDAO->listarTurmas(); // Busca as turmas associadas ao administrador

    // echo "<pre>";
    // var_dump($turmas);
} else {
    echo "<script>
        alert('Acesso não autorizado!');
        window.location.href = '../index.php';
    </script>";
    exit;
}


?>
