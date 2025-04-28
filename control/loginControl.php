<?php
require_once '../model/DAO/AdmDAO.php';
require_once '../model/DAO/UsuarioDAO.php';

session_start();

if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Cria instâncias das classes DAO
    $admDAO = new AdmDAO();
    $usuarioDAO = new UsuarioDAO();

    // Tentativa de login para Administrador
    $dadosAdm = $admDAO->validarLogin($email, $senha);

    // Verifica se o usuário é um administrador
    if (!empty($dadosAdm)) {
        $idAdm = (int) $dadosAdm['id_Adm']; // Converte para inteiro
        if ($idAdm > 0) {  // Verifica se o ID é válido
            $_SESSION['usuario'] = $dadosAdm['email'];
            $_SESSION['perfil'] = 'administrador';
            $_SESSION['id_usuario'] = $idAdm;

            // Alerta de sucesso e redirecionamento
            echo "<script>
                    alert('Logado como administrador!'); 
                    window.location.href = '../view/telaAdm.php';
                  </script>";
            exit(); 
        }
    } 

    // Caso não seja administrador, tenta validar como professor ou responsável
    $dadosUsuario = $usuarioDAO->validarLogin($email, $senha);

    // Verifica se o usuário é professor ou responsável
    if (!empty($dadosUsuario)) {
        // Verifica o perfil do usuário
        $perfil = $dadosUsuario['perfil'];
        $idUsuario = (int) $dadosUsuario['id_usuario'];

        // Verifica o perfil e redireciona
        if ($perfil === 'professor') {
            $_SESSION['usuario'] = $dadosUsuario['email'];
            $_SESSION['perfil'] = 'professor';
            $_SESSION['id_usuario'] = $idUsuario;

            // Redireciona para a página do professor
            echo "<script>
                    alert('Logado como professor!'); 
                    window.location.href = '../view/telaProfessor.php';
                  </script>";
            exit();
        } elseif ($perfil === 'responsavel') {
            $_SESSION['usuario'] = $dadosUsuario['email'];
            $_SESSION['perfil'] = 'responsavel';
            $_SESSION['id_usuario'] = $idUsuario;

            // Redireciona para a página do responsável
            echo "<script>
                    alert('Logado como responsável!'); 
                    window.location.href = '../view/telaResponsavel.php';
                  </script>";
            exit();
        } else { 
            // Caso o perfil seja inválido
            echo "<script>
                    alert('Perfil inválido!'); 
                    window.location.href = '../index.php';
                  </script>";
        }
    } else {
        // Alerta de erro caso o usuário não seja encontrado
        echo "<script>
                alert('Usuário não encontrado!'); 
                window.location.href = '../index.php';
              </script>";
    }
}
?>
