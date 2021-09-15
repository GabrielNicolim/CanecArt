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
                    switch ($_GET['notice']) {
                        case 'invalidemail':
                            echo '<div class="error">Insira um email válido!</div>';
                            break;
                        case 'success':
                            echo '<div class="error">Enviamos um email de recuperação para sua conta, cheque a caixa de spam!</div>';
                            break;
                    }
                }
            ?>
            
            <form action="../../app/recoverPassword.php" method="POST">
                <div class="top">
                    <h2>Recuperar Senha</h2>

                    <a href="../../index.php">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                    </a>
                </div>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" required>

                <input type="submit" value="Enviar">
            </form>

            <a href="login.php">
                Lembrou a senha? Logue-se!
            </a>
        </div>
    </div>
</body>
</html>