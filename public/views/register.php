<?php
    session_start();

    $page_title = 'Cadastro';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>',
                    '<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/form.css">',
                    '<script src="../../js/validatepassword.js"></script>'];

    require("../includes/head.php");

?>

    <div class="container">
        <div class="content">
            <?php if (isset($_GET['error'])) {
                switch ($_GET['error']) {
                    case 'emailregistered':
                        echo '<div class="error">Email já cadastrado. <a href="login.php">Faça Login!</a></div>';
                        break;
                    case 'CPFregistered':
                        echo '<div class="error">CPF já cadastrado. <a href="recover.php">Esqueceu a senha?</a></div>';
                        break;
                    case 'datamissing':
                    case 'invalidemail':
                    case 'invalidCPF':
                        echo '<div class="error">Erro no dados do registro</div>';
                        break;
                    case 'differentpasswords':
                        echo '<div class="error">Erro no registro</div>';
                        break;
                }
            }
            ?>
            <form action="../../app/registerLogic.php" method="POST" id="form-register" autocomplete="off">
                <div class="top">
                    <h2>Cadastro</h2>

                    <a href="../../index.php">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                    </a>
                </div>

                <label for="name">Nome</label>
                <input type="text" name="name" id="name" placeholder="Seu nome" maxlength="256" required>

                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" placeholder="CPF" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" maxlength="14" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" maxlength="256" required>

                <label for="password">Senha</label>
                <input type="password" name="password" id="password" placeholder="Senha" maxlength="256" required>
                <span id="password_level"></span>

                <label for="confirm-password">Confirmar Senha</label>
                <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirmar" maxlength="256" required>
            
                <input type="submit" value="Cadastrar-se">
            </form>

            <a href="login.php">
                Já possui um cadastro? Faça login!
            </a>
        </div>
    </div>
</body>
</html>