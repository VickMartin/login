<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de login</title>
    <link rel="stylesheet" href="../css/login.css">
  
</head>

<body>
    <section class="menu">
        <section class="logo">
            <div class="img">
                <img src="../imagens/logo.jpeg" alt="imagen login" width="100%" height="500px">
            </div>
        </section>
        <section class="formulario">
            <form action="../control/loginControl.php" method="post">
                <h2>Tela de login</h2>
                
                <label for="email">Email:</label> 
                <input type="text" name="email" placeholder="Digite seu e-mail" required>
                <label for="senha">Senha:</label> 
                <input type="password" name="senha" placeholder="Digite sua senha" required>
                
                 <input class="inputSubmit" type="submit" name="submit" value="Logar">
                
                <center><a href="../view/alterarSenha.php">Esqueci minha senha!</a></center>
            </form>


        </section>
    </section>
</body>

</html>