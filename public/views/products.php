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
    </div>
</body>
</html>