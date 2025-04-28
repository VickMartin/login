<?php
require_once '../model/DAO/AdmDAO.php';
require_once '../model/DAO/UsuarioDAO.php';

session_start();

if (isset($_POST['submit']) && !empty($_POST['email'])) {
    $email = $_POST['email'];

    var_dump($email);
    // Cria instâncias dos DAOs
    $admDAO = new AdmDAO();
    $usuarioDAO = new UsuarioDAO();

    // Verifica se o e-mail pertence a um administrador
    $dadosAdm = $admDAO->buscarEmail($email);

    var_dump($dadosAdm);

    if ($dadosAdm) {
        // E-mail encontrado para administrador, pode criar o processo de reset
        $_SESSION['email'] = $email;
        header("Location: ../view/resetarSenha.php?perfil=administrador");
        exit();
    }

    // Caso não seja administrador, verifica como usuário
    $dadosUsuario = $usuarioDAO->buscarEmail($email);

    if ($dadosUsuario) {
        // E-mail encontrado para usuário, pode criar o processo de reset
        $_SESSION['email'] = $email;
        header("Location: ../view/resetarSenha.php?perfil=usuario");
        exit();
    } else {
        // E-mail não encontrado
        echo "<script>
                alert('E-mail não encontrado!'); 
                window.location.href = '../index.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Por favor, insira seu e-mail!'); 
            window.location.href = '../index.php';
          </script>";
}
?>