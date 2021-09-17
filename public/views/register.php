<?php
    session_start();

    $page_title = 'Cadastro';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>',
                    '<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/form.css">'];

    require("../includes/head.php");

?>

    <div class="container">
        <div class="content">
            <?php if (isset($_GET['error'])) {
                echo '<div class="error">Erro no registro</div>';
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