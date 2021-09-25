<?php
    session_start();

    $page_title = 'Produtos';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/product-page.css">'];

    require("../includes/head.php");
    require("../../app/functions.php");
    require("../../app/db/connect.php");

    $product_id = sanitizeString($_GET['id']);

    if (empty($product_id) || !is_numeric($product_id)) {
        exit;
    }

    $query = 'SELECT * FROM products WHERE id_product = :product_id';

    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $stmt -> execute();

    if ($stmt -> rowCount() == 0) {
        //exit;
    }

    $data = $stmt -> fetch(PDO::FETCH_ASSOC);

    $query = 'SELECT COUNT(*) FROM order_products WHERE fk_product = :product_id';
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $stmt -> execute();
    $orders = $stmt -> fetch(PDO::FETCH_ASSOC);

?>

    <a href="car.php" class="shop-car">
        <img src="../icons/shop-car.svg" alt="">
    </a>

    <div class="container">
        <?php

            include("../includes/header.php");

        ?>
    
        <section class="product-overview">
            <div class="top">
                <div class="left">
                    <?php
                        if (empty($data['photo_product']) || !file_exists('../images/'.$data['photo_product']))
                        echo'<img src="../images/missing-image.png" alt="">';
                        else echo '<img src="../images/'.$data['photo_product'].'" alt="">';
                    ?>
                </div>

                <div class="right">
                    <div class="name-product"><?=$data['name_product']?></div>
                    
                    <div class="sold-products">
                        Pedidos: <?=$orders['count'] ?>
                    </div>

                    <div class="price-procut">R$ <?= str_replace('.',',',$data['price_product']) ?></div>
                    
                    <a href="#" class="btn">
                        Comprar
                    </a>

                    <div class="product-avalible">
                        Disponível: <?=$data['quantity_product']?>
                    </div>

                    <div class="description">
                        <h2>Descrição</h2>
                        <span class="text"><?=$data['description_product']?><br>
                        
                        </span>

                        <?php
                            foreach(explode(' ',$data['type_product']) as $tag) {
                                echo'<a href="products.php?type_product='.$tag.'" class="tag">
                                    '.ucfirst($tag).'
                                </a>';
                            }
                        ?>
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