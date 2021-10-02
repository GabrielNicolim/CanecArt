<?php
    session_start();

    $page_title = 'Produtos';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/product-page.css">',
                    '<script src="../../js/products.js"></script>'];

    require("../includes/head.php");
    require("../../app/functions.php");
    require("../../app/db/connect.php");

    if (!isset($_GET['id'])) {
        include('product-missing.php');
        exit;
    }

    $product_id = sanitizeString($_GET['id']);

    if (empty($product_id) || !is_numeric($product_id)) {
        include('product-missing.php');
        exit;
    }

    $query = 'SELECT * FROM products WHERE id_product = :product_id';

    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $stmt -> execute();

    if ($stmt -> rowCount() == 0) {
        include('product-missing.php');
        exit;
    }

    $data = $stmt -> fetch(PDO::FETCH_ASSOC);

    $query = 'SELECT COUNT(*) FROM order_products WHERE fk_product = :product_id';
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $stmt -> execute();
    $orders = $stmt -> fetch(PDO::FETCH_ASSOC);

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

        <section class="product-overview">
            <div class="top">
                <div class="left">
                    <?php
                        if (empty($data['photo_product']) || !file_exists('../images/'.$data['photo_product']))
                        echo'<img src="../images/missing-image.png" alt="missing-image">';
                        else echo '<img src="../images/'.$data['photo_product'].'" alt="Foto do produto">';
                    ?>
                </div>

                <div class="right">
                    <div class="name-product"><?=$data['name_product']?></div>
                    
                    <div class="sold-products">
                        Pedidos: <?=$orders['count'] ?>
                    </div>

                    <div class="price-procut">
                        R$ <?= str_replace('.',',',$data['price_product']) ?>
                    </div>

                    <a  class="btn <?= $data['quantity_product'] == 0 ? 'disabled' : '' ?>">
                        Comprar
                    </a>

                    <?php   
                        if($data['quantity_product'] != 0) {
                            echo "<div class='product-avalible'>Disponível: ".$data['quantity_product']."</div>";
                        } else {
                            echo "<div class='out'>Produto fora de estoque</div>";
                        }
                    ?>                     

                    <div class="description">
                        <h2>Descrição</h2>
                        <span class="text"><?=$data['description_product']?><br></span>

                        <div class="tags">
                            <?php
                                foreach(explode(' ',$data['type_product']) as $tag) {
                                    echo'<a href="products.php?type_product='.$tag.'" class="tag">
                                        '.ucfirst($tag).'
                                    </a>';
                                }
                            ?>
                        </div><br>
                        <p>Material: Cerâmica<br>
                        - Impressão em alta definição<br>
                        - Não sai ao lavar<br>
                        - Pode ser levado ao micro-ondas e lava-louças.<br>
                        - Capacidade: 325 ml<br><br>
                                    
                        Altura: 9.50 cm<br>
                        Largura: 8.00 cm<br>
                        Comprimento: 8.00 cm<br>
                        Peso: 330 g<br>
                        </p>
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