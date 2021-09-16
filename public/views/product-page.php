<?php
    session_start();

    $page_title = 'Produtos';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/product-page.css">'];

    require("../includes/head.php");

?>

    <div class="shop-car">
        <img src="../icons/shop-car.svg" alt="">
    </div>

    <div class="container">
        <?php

            include("../includes/header.php");

        ?>
    
        <section class="product-overview">
            <div class="top">
                <div class="left">
                    <img src="../images/card1-image.png" alt="">
                </div>

                <div class="right">
                    <div class="name-product">Product Product</div>
                    
                    <div class="sold-products">
                        Pedidos: 123
                    </div>

                    <div class="price-procut">R$ 90.99</div>
                    <div class="sold-products">
                        245 unidades restantes
                    </div>
                    <a href="#" class="btn">
                        Comprar
                    </a>

                    <div class="product-avalible">
                        Disponível: 12
                    </div>

                    <div class="description">
                        <h2>Descrição</h2>
                        <span class="text">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptas harum eveniet maiores. Libero laborum commodi optio distinctio, nobis quaerat ipsam, officia eveniet asperiores cum velit. Animi dolores natus perferendis. Perferendis.
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptas harum eveniet maiores. Libero laborum commodi optio distinctio, nobis quaerat ipsam, officia eveniet asperiores cum velit. Animi dolores natus perferendis. Perferendis.
                        </span>

                        <a href="#" class="tag">
                            Categoria
                        </a>
                    </div>
                </div>
            </div>
        </section>    

        <?php

            include("../includes/footer.php");

        ?>
    </div>
</body>
</html>