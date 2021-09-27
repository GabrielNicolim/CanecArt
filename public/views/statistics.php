<?php

    session_start();

    $page_title = 'Estatísticas';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/statistics.css">'];

    require("../includes/head.php");
    require("../../app/db/env.php");

?>

    <a href="cart.php" class="shop-car">
        <img src="../icons/shop-car.svg" alt="cart_icon">
        <span><?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) echo count($_SESSION['cart']) ?></span>
    </a>

    <div class="container">
    
        <?php

            include("../includes/header.php");

        ?>

        <section>

            <img src="https://www.encartale.com.br/smart/modulos/produto/imagens/grande/placa-atencao-em-obras_162-17.jpg" alt="Em obras">

        </section>
    </div>

    <?php

        include("../includes/footer.php");

    ?>

</body>
</html>