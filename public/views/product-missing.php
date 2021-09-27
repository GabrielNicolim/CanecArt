
    <a href="cart.php" class="shop-car">
        <img src="../icons/shop-car.svg" alt="cart_icon">
        <span><?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) echo count($_SESSION['cart']) ?></span>
    </a>

    <div class="container">
        <?php

            include("../includes/header.php");

        ?>

        <section class="product-overview">
            <div class="top">
                <div class="left">
                    <img src="../images/missing-image.png" alt="aaaaa">
                </div>

                <div class="right">
                    <div class="name-product"><h1>404</h1></div>
                    
                    <div class="sold-products">
                        Sentimos muito
                    </div>

                    <div class="price-procut">Produto não encontrado</div>
                    
                    <a href="products.php" class="btn">
                        Voltar para os produtos!
                    </a>

                    <div class="product-avalible">
                        Você deve só ter acessado o link errado
                    </div>

                    <div class="description">
                        <h2>Descrição</h2>
                        <span class="text">Acontece<br>
                        </span>
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