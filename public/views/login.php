<?php

    session_start();

    if (isset($_SESSION['idUser'])) {
        header('Location: products.php');
        exit;
    }

    $page_title = 'Login';
    $style_sheets = ['../css/style.css', 
                     '../css/register.css'];

    $javascript = ['https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous'];
    $icon_folder = '../images/logos/favicon.png';

    require("../includes/head.php");

?>


    <div class="container">
        <div class="content">
            <?php
                if (isset($_GET['error'])) {
                    echo '<div class="error">Email ou senha inválidos!</div>';
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
                <input type="email" name="email" id="email" placeholder="Email" required>

                <label for="password">Senha</label>
                <input type="password" name="password" id="password" placeholder="Senha" required>
            
                <input type="submit" value="Enviar">
            </form>

            <a href="register.php">
                Ainda não possui cadastro? Cadastre-se!
            </a>
        </div>
    </div>
</body>
</html>