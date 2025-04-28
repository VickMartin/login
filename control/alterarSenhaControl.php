<?php
session_start();

// Verifica se o e-mail foi armazenado na sessão
if (!isset($_SESSION['email'])) {
    echo "<script>
            alert('Sessão expirada ou e-mail não encontrado!');
            window.location.href = '../index.php';
        </script>";
    exit();
}

// Obtém o e-mail armazenado na sessão
$email = $_SESSION['email'];

// Verifica se os campos de senha foram enviados via POST
if (isset($_POST['senha']) && isset($_POST['confirmar_senha'])) {
    // Recebe os valores das senhas
    $novaSenha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmar_senha'];

    // Verifica se as senhas coincidem
    if ($novaSenha === $confirmarSenha) {
        // Cria instâncias dos DAOs
        require_once '../model/DAO/AdmDAO.php';
        require_once '../model/DAO/UsuarioDAO.php';

        $admDAO = new AdmDAO();
        $usuarioDAO = new UsuarioDAO();

        // Tentando alterar a senha do administrador
        if ($admDAO->alterarSenha($email, $novaSenha)) {
            echo "<script>
                    alert('Senha alterada com sucesso para o administrador!Retornando para tela de login.');
                    window.location.href = '../view/login.php';
                </script>";
        }
        // Se não encontrou o e-mail na tabela de administradores, tenta como usuário
        elseif ($usuarioDAO->alterarSenha($email, $novaSenha)) {
            echo "<script>
                    alert('Senha alterada com sucesso para o usuário! Retornando para tela de login.');
                    window.location.href = '../view/login.php';
                </script>";
        } else {
            // Caso o e-mail não seja encontrado em ambas as tabelas
            echo "<script>
                    alert('Erro ao alterar a senha. Usuário ou administrador não encontrado.');
                    window.location.href = '../view/login.php';
                </script>";
        }

        // Limpa a sessão após a alteração
        session_unset();
        session_destroy();
    } else {
        // Se as senhas não coincidirem
        echo "<script>
                alert('As senhas não coincidem. Tente novamente.');
                window.location.href = 'resetarSenha.php';
            </script>";
    }
} else {
    // Se os campos de senha não forem enviados
    echo "<script>
            alert('Por favor, preencha todos os campos de senha.');
            window.location.href = 'resetarSenha.php';
        </script>";
}
?>
