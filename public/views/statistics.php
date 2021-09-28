<?php

    session_start();

    $page_title = 'Estatísticas';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/statistics.css">'];

    require("../includes/head.php");
    require("../../app/db/env.php");

?>

    <div class="shop-car">  
        <a href="cart.php">
            <img src="../icons/shop-car.svg" alt="cart_icon">

            <span>
                <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) echo count($_SESSION['cart']) ?>
            </span>
        </a>
    </div>

    <div class="container">
    
        <?php

            include("../includes/header.php");

        ?>

        <section>

            <img src="https://www.encartale.com.br/smart/modulos/produto/imagens/grande/placa-atencao-em-obras_162-17.jpg" alt="Em obras">

        </section>
        
        <?php

            include("../includes/footer.php");

        ?>
    </div>

</body>
</html>