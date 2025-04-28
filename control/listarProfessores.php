<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../model/DAO/UsuarioDAO.php';

// Verifica se o administrador está logado
if (isset($_SESSION['id_usuario']) && $_SESSION['perfil'] === 'administrador') {
    $idAdm = $_SESSION['id_usuario']; // ID do administrador logado

    $usuarioDAO = new UsuarioDAO();
    $usuarios = $usuarioDAO->listarProfessores(); // Lista os professores associados ao administrador

    // Verifica se a lista não está vazia para exibir os professores ou uma mensagem de erro
    if (!empty($usuarios)) {
        // Agora você pode exibir a lista dos professores no frontend
        // echo "<pre>";
        // var_dump($usuarios);
    } else {
        echo "Nenhum professor encontrado para este administrador.";
    }
} else {
    echo "<script>
        alert('Acesso não autorizado!');
        window.location.href = '../index.php';
    </script>";
    exit;
}
?>

