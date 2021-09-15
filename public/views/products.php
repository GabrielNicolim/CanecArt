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

        <?php

            include("../includes/header.php");

        ?>
    
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

        <!-- Base Product --> 
            <div href="#product" class="product">
                <a href="#teste">
                    <img src="../images/card1-image.png" alt="">
                    
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum, atque cumque? Animi necessitatibus quos officiis saepe placeat non veniam laudantium, vero culpa laborum omnis magni quae. Quae iste quidem expedita!
                    </p>
                    
                    <div class="price_product">
                        R$ 90.99
                    </div>
                </a>

                <a href="#" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                    </svg>

                    <span>Comprar</span>
                </a>
            </div>
        <!-- End Base Product --> 

        </section>

        <?php

            include("../includes/footer.php");

        ?>
    </div>
</body>
</html>