<?php

    session_start();

    $page_title = 'Devs';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/development.css">'];

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
        
        <section class="developers">
            <div class="dev">
                <div class="right">
                        <img src="../images/dev-bianca.jpg">
                </div>

                <div class="left">                                
                    <p>Número de chamada: 03</p>                
                    <p>Nome: Bianca Oliveira De Camargo </p>
                    <p>Email: <a href="mailto:bianca.camargo@unesp.br">bianca.camargo@unesp.br <img src="../icons/external-link-alt-solid.svg"></a></p>
                    
                </div>
            </div>
        
        
            <div class="dev">
                <div class="right">
                        <img src="../images/dev-carla.jpg">
                    </div>   
                        
                    <div class="left">
                        <p>Número de chamada: 04</p>
                        <p>Nome: Carla Julia Franco de Toledo</p>
                        <p>Email: <a href="mailto:carla.franco@unesp.br">carla.franco@unesp.br <img src="../icons/external-link-alt-solid.svg"></a></p>
                    </div>
            </div>
            
                    
            <div class="dev">                       
                    <div class="right">
                        <img src="../images/dev-felipe.jpg">
                    </div>         
                    <div class="left">
                        <p>Número de chamada: 06</p>                
                        <p>Nome: Felipe Lima Estevanatto </p>
                        <p>Email: <a href="mailto:felipe.estevanatto@unesp.br">felipe.estevanatto@unesp.br <img src="../icons/external-link-alt-solid.svg"></a></p>
                    </div>
            </div>
        
                
            <div class="dev">       
                <div class="right">
                    <img src="../images/dev-gabriel.jpg">
                </div>
    
                <div class="left">
                    <p>Número de chamada: 08</p>                
                    <p>Nome: Gabriel Gomes Nicolim </p>
                    <p>Email: <a href="mailto:gabriel.nicolim@unesp.br">gabriel.nicolim@unesp.br <img src="../icons/external-link-alt-solid.svg"></a></p>
                </div>
            </div>
            
            
        <div class="dev">
            
                <div class="right">
                <img src="../images/dev-samuel.jpg">
                </div>

            
                <div class="left">
                    <p>Número de chamada: 32</p>                
                    <p>Nome: Samuel Sensolo Goldflus  </p>
                    <p>Email: <a href="mailto:samuel.goldflus@unesp.br">samuel.goldflus@unesp.br <img src="../icons/external-link-alt-solid.svg"></a></p>
                </div>
            </div>
        </section>
    
        <?php

            include("../includes/footer.php");

        ?>
    </div>
</body>
</html>