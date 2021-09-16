<?php

    session_start();

    $page_title = 'Meu perfil';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/cart.css">'];

    require("../includes/head.php");

?>

<section>

<h1>Perfil do usuário</h1>

<a href="../../app/logout.php">Logout</a>

</section>

    <?php

        include("../includes/footer.php");

    ?>

</body>
</html>