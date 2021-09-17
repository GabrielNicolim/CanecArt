<?php

    session_start();

    $page_title = 'Carrinho(1)';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/cart.css">'];

    require("../includes/head.php");
    require("../../app/db/env.php");

?>

<section>

<h1>Carrinho</h1>

</section>

    <?php

        include("../includes/footer.php");

    ?>

</body>
</html>