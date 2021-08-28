<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/register.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <!-- <div class="error">ERRO</div> -->
            
            <form action="../app/loginLogic.php" method="POST">
                <div class="top">
                    <h2>Login</h2>

                    <a href="../index.html">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                    </a>
                </div>

                <label for="email">Email</label>
                <input type="email" name="email" id="email">

                <label for="password">Senha</label>
                <input type="password" name="password" id="password">
            
                <input type="submit" value="Enviar">
            </form>

            <a href="register.php">
                Ainda não possui cadastro? Cadastre-se!
            </a>
        </div>
    </div>
</body>
</html>