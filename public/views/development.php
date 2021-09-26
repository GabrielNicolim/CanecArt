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
        <img src="../icons/shop-car.svg" alt="">
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
                    <p>Email: bianca.camargo@unesp.br</p>
                </div>
            </div>
        
        
            <div class="dev">
                <div class="right">
                        <img src="../images/dev-carla.jpg">
                    </div>   
                        
                    <div class="left">
                        <p>Número de chamada: 04</p>
                        <p>Nome: Carla Julia Franco de Toledo</p>
                        <p>Email: carla.franco@unesp.br</p>
                    </div>
            </div>
            
                    
            <div class="dev">                       
                    <div class="right">
                        <img src="../images/dev-felipe.jpg">
                    </div>         
                    <div class="left">
                        <p>Número de chamada: 06</p>                
                        <p>Nome: Felipe Lima Estevanatto </p>
                        <p>Email: felipe.estevanatto@unesp.br</p>
                    </div>
            </div>
        
                
            <div class="dev">       
                <div class="right">
                    <img src="../images/dev-gabriel.jpg">
                </div>
    
                <div class="left">
                    <p>Número de chamada: 08</p>                
                    <p>Nome: Gabriel Gomes Nicolim </p>
                    <p>Email: gabriel.nicolim@unesp.br</p>
                </div>
            </div>
            
            
        <div class="dev">
            
                <div class="right">
                <img src="../images/dev-samuel.jpg">
                </div>

            
                <div class="left">
                    <p>Número de chamada: 32</p>                
                    <p>Nome: Samuel Sensolo Goldflus  </p>
                    <p>Email: samuel.goldflus@unesp.br</p>
                </div>
            </div>
        </section>
    
        <?php

            include("../includes/footer.php");

        ?>
    </div>
</body>
</html>