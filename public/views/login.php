<?php

    session_start();

    if (isset($_SESSION['idUser'])) {
        header('Location: products.php');
        exit;
    }

    $page_title = 'Login';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>',
                    '<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/form.css">'];

    require("../includes/head.php");

?>

    <div class="container">
        <div class="content">
            <?php
                if (isset($_GET['notice'])) {
                    echo '<div class="success">Senha alterada com sucesso!</div>';
                }
                if (isset($_GET['error'])) {
                    switch ($_GET['error']) {
                        case 'invaliddata':
                            echo '<div class="error">Email ou senha inválidos!</div>';
                            break;
                        case 'missingdata':
                            echo '<div class="error">Informações inválidas!</div>';
                            break;
                        case 'disabled':
                            $myDateTime = DateTime::createFromFormat('Y-m-d', $_GET['date']);
                            echo '<div class="error">Sua conta foi desativada em '.$myDateTime->format('d/m/Y').'!<br>
                            Se acha que foi um engano <a href="development.php">fale conosco por email</a></div>';
                            break;
                    }
                }
            ?>
            
            <form action="../../app/loginLogic.php" method="POST">
                <div class="top">
                    <h2>Login</h2>

                    <a href="../../index.php">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                    </a>
                </div>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" maxlength="256" required>
                
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" placeholder="Senha" maxlength="256" required>
                <div id="recover">Esqueceu sua senha? <a href="recover.php">Recuperar senha</a></div>

                <input type="submit" value="Logar">
            </form>

            <a href="register.php">
                Ainda não possui cadastro? Cadastre-se!
            </a>
        </div>
    </div>
</body>
</html>