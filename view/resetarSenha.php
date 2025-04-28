<?php
session_start();

// Verifica se o e-mail foi armazenado na sessão
if (!isset($_SESSION['email'])) {
    echo "Sessão expirada ou e-mail não encontrado!";
    exit();
}

// Obtém o perfil (administrador ou usuário) da URL
$perfil = isset($_GET['perfil']) ? $_GET['perfil'] : ''; // Verifica se o 'perfil' existe na URL

// Obtém o e-mail armazenado na sessão
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <script>
        // Função JavaScript para verificar se as senhas são iguais
        function validarSenhas() {
            var senha = document.getElementById("senha").value;
            var confirmarSenha = document.getElementById("confirmar_senha").value;

            if (senha !== confirmarSenha) {
                alert("As senhas não coincidem. Tente novamente.");
                return false; // Impede o envio do formulário
            }

            return true; // Permite o envio do formulário
        }
    </script>
    <link rel="stylesheet" href="../css/alterarSenha.css">
</head>
<body>
    <div class="container">
        <fieldset>
         <legend>Alteração de Senha</legend>
        <p>Olá, <strong><?php echo $email; ?></strong>.Para prosseguir com a alteração de senha, insira uma nova senha abaixo.</p>
        
        <form action="../control/alterarSenhaControl.php" method="post" onsubmit="return validarSenhas()">
            <input type="hidden" name="perfil" value="<?php echo $perfil; ?>"> <!-- Passando o perfil de forma oculta -->

            <div class="form-group">
                <label for="senha">Nova Senha:</label>
                <input type="password" name="senha" id="senha" required>
            </div>

            <div class="form-group">
                <label for="confirmar_senha">Confirmar Nova Senha:</label>
                <input type="password" name="confirmar_senha" id="confirmar_senha" required>
            </div>
            
            <div class="form-group">
                <center><input type="submit" value="Alterar Senha"></center>
            </div>
            <center><a href="../index.php">Voltar à tela inicial</a></center>
        </form>
    </fieldset>
    </div>
</body>
</html>
