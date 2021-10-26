<?php

    session_start();
    require("../../app/db/connect.php");

    if (isset($_SESSION['idUser'])) {
        header('Location: products.php');
        exit;
    }

    $page_title = 'Nova senha';

    $style_scripts = ['<script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>',
                    '<link rel="stylesheet" href="../css/form.css">',
                    '<script src="../../js/validatepassword.js"></script>'];

    require("../includes/head.php");

    $selector = filter_var($_GET['selector'],FILTER_SANITIZE_STRING);
    $validator = filter_var($_GET['validator'],FILTER_SANITIZE_STRING);
    $validRequest = false;

    if (empty($selector) || empty($validator)) {
        $validRequest = false;
    }

    $currentTime = date("U");

    $query = 'SELECT id_pwdrequest, selector_pwdrequest, token_pwdrequest, fk_email FROM eq3.pwdReset 
              WHERE selector_pwdrequest = :selector AND expires_pwdrequest >= :currentTime';

    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':selector', $selector, PDO::PARAM_STR);
    $stmt -> bindValue(':currentTime', $currentTime, PDO::PARAM_STR);
    $stmt -> execute();
 
    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($stmt -> rowCount() > 0 && password_verify(hex2bin($validator), $return['token_pwdrequest'])) {
        
        $validRequest = true;

    }

?>

    <div class="container">
        <div class="content">
            <?php
                if ($validRequest === false) {
                    echo '<div class="error">Sua requisição expirou, <a href="recover.php">faça uma nova!</a></div>';
                } else {
            ?>
                <?php
                    if (isset($_GET['notice'])){
                        if ($_GET['notice'] == 'weakpassword') {
                            echo '<div class="error">Sua senha é muito fraca, use numeros e letras maiusculas</div>';
                        }
                    }
                ?>
                <form action="../../app/newpassword.php" method="POST">
                    <div class="top">
                        <h2>Nova senha para: <?=$return['fk_email']?></h2>

                        <a href="../../index.php">
                            <i class="fas fa-arrow-alt-circle-left"></i>
                        </a>
                    </div>

                    <input type="hidden" name="selector" value="<?=$selector?>">
                    <input type="hidden" name="token" value="<?=$validator?>">

                    <label for="password">Nova senha:</label>
                    <input type="password" name="newpassword" id="password" placeholder="Nova senha" maxlength="256" required>
                    <span id="password_level"></span>

                    <label for="password">Confirmar nova senha:</label>
                    <input type="password" name="confirmpassword" id="newpassword" placeholder="Confirmar senha" maxlength="256" required>
                    <div id="recover">Lembrou sua senha? <a href="login.php">Faça login</a></div>

                    <input type="submit" value="Enviar">
                </form>
            <?php   
                }   
            ?>
        </div>
    </div>
</body>
</html>