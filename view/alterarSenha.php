<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de login</title>
    <link rel="stylesheet" href="../css/alterarSenha.css">
</head>

<body>
    
        <section class="formulario">
            <fieldset>
                <legend>Alteração de Senha</legend>
            
                    <form action="../control/buscarEmail.php" method="post">
                            
                            
                            <label for="email" id="email">Por favor digite seu E-mail:</label> 
                            <input type="text" name="email" placeholder="Digite seu e-mail" required>
                            <input id="inputBuscar" type="submit" name="submit" value="Buscar">
                            <br>
                            <center><a href="../index.php">Voltar à tela inicial</a></center>
                            
                    </form>
                
            </fieldset>
        </section>
    </section>
</body>

</html>