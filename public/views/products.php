<?php
    session_start();

    $page_title = 'Produtos';
    $style_sheets = ['../css/style.css', 
                     '../css/products.css'];
    $icon_folder = '../images/logos/favicon.png';

    require("../includes/head.php");

?>

    <div class="shop-car">
        <img src="../icons/shop-car.svg" alt="">
    </div>

    <div class="container">
        <header id="top">
            <div class="content">
                <a href="#home" class="logo">
                    Canec<span>Art</span>
                </a>
        
                <nav>
                    <a href="../index.php" class="btn">Home</a>
                    <a href="views/products.php" class="btn active">Produtos</a>
                    <a href="#Estatics" class="btn">Estatísticas</a>
                    <a href="devs.php" class="btn">Desenvolvimento</a>
                    <a href="register.php" class="btn primary">Cadastre-se</a>
                </nav> 
            </div> 
        </header>
    
        <section class="search">
            <form action="" method="GET">
                <span>Busca:</span>
                <input type="text" name="name_product" id="name_product" placeholder="Nome">
                
                <select name="type_product" id="type_product">
                    <option value="valor1" selected>Tipo</option>
                    <option value="valor2">Valor 1</option>
                    <option value="valor3">Valor 2</option>
                </select>

                <div class="value">
                    <span>Preço:</span>
                    <input type="number" name="min_value_product" id="min_value_product" placeholder="min">
                    <input type="number" name="max_value_product" id="max_value_product" placeholder="max">
                </div>

                <input type="submit" value="Buscar">
            </form>
        </section>

        <section id="products">
            <div class="product">
                <img src="../images/card1-image.png" alt="">

                <a href="#" class="btn primary">
                    Comprar agora
                </a>

                <a href="#" class="btn">
                    adicionar ao carrinho
                </a>
            </div>
        </section>

<?php

    include("../includes/footer.php");

?>