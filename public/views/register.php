<?php
    session_start();

    $page_title = 'Cadastro';
    $style_sheets = ['../css/style.css', 
                     '../css/form.css'];

    $javascript = ['https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous'];
    $icon_folder = '../images/logos/favicon.png';

    require("../includes/head.php");

?>

    <div class="container">
        <div class="content">
            <?php if (isset($_GET['error'])) {
                echo '<div class="error">'.print_r($_GET['error']).'</div>';
            }
            ?>
            <form action="../../app/registerLogic.php" method="POST">
                <div class="top">
                    <h2>Cadastro</h2>

                    <a href="../../index.php">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                    </a>
                </div>

                <label for="name">Nome</label>
                <input type="text" name="name" id="name" placeholder="Seu nome" required>

                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" placeholder="CPF" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" required>

                <label for="password">Senha</label>
                <input type="password" name="password" id="password" placeholder="Senha" required>

                <label for="confirm-password">Confirmar Senha</label>
                <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirmar" required>
            
                <input type="submit" value="Enviar">
            </form>

            <a href="login.php">
                Já possui um cadastro? Faça login!
            </a>
        </div>
    </div>
</body>
</html>