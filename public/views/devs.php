<?php

    session_start();

    $page_title = 'Devs';
    $style_sheets = ['../css/style.css', 
                     '../css/home.css',
                     '../css/development.css'];
    $icon_folder = '../images/logos/favicon.png';

    require("../includes/head.php");

?>

<div class="shop-car">
        <img src="public/icons/shop-car.svg" alt="">
    </div>
    
     <div class="container">
        <header id="top">
            <div class="content">
                <a href="#home" class="logo">
                    Canec<span>Art</span>
                </a>
        
                <nav>
                    <a href="../../index.php" class="btn">Home</a>
                    <a href="products.php" class="btn">Produtos</a>
                    <a href="#Estatics" class="btn">Estatísticas</a>
                    <a href="devs.php" class="btn active">Desenvolvimento</a>
                    <a href="register.php" class="btn primary">Cadastre-se</a>
                </nav> 
            </div> 
        </header>
        
        <center>
        
        <section class="nomes">
               <div class="right">
                    <img src="../images/dev-samuel.jpg">
             </div>

            <div class="left">                                
                <p>Número de chamada: 03</p>                
                <p>Nome: Bianca Oliveira De Camargo </p>
                <p>Email: bianca.camargo@unesp.br</p>
            </div>
        </section>
       
       
        <section class="nomes">
               <div class="right">
                    <img src="../images/dev-samuel.jpg">
                </div>   
                    
                <div class="left">
                    <p>Número de chamada: 04</p>
                    <p>Nome: Carla Julia Franco de Toledo</p>
                    <p>Email: carla.franco@unesp.br</p>
                </div>
        </section>
        
                
         <section class="nomes">                       
                <div class="right">
                    <img src="../images/dev-samuel.jpg">
                </div>         
                <div class="left">
                    <p>Número de chamada: 06</p>                
                    <p>Nome: Felipe Lima Estevanatto </p>
                    <p>Email: felipe.estevanatto@unesp.br</p>
                </div>
        </section>
       
             
        <section class="nomes">       
            <div class="right">
                <img src="../images/dev-samuel.jpg">
            </div>
 
            <div class="left">
                <p>Número de chamada: 08</p>                
                <p>Nome: Gabriel Gomes Nicolim </p>
                <p>Email: gabriel.nicolim@unesp.br</p>
            </div>
        </section>
        
        
       <section class="nomes">
           
            <div class="right">
               <img src="../images/dev-samuel.jpg">
            </div>

           
            <div class="left">
                <p>Número de chamada: 32</p>                
                <p>Nome: Samuel Sensolo Goldflus  </p>
                <p>Email: samuel.goldflus@unesp.br</p>
            </div>
        </section>
            
       </center>

<?php

    include("../includes/footer.php");

?>