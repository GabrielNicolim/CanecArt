<?php
    session_start();

    $page_title = 'Produtos';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/products.css">'];

    require("../includes/head.php");
    require("../../app/db/connect.php");
    require("../../app/functions.php");

    // Select all distinct type_products, convertir the string to an array with every space
    // then unnesting this array into a row per word.
    $query = "SELECT DISTINCT UNNEST(string_to_array(type_product,' ')) AS string FROM products";

    $stmt = $conn -> prepare($query);
    $stmt -> execute();
    $product_types = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    
?>

    <a href="cart.php" class="shop-car">
        <img src="../icons/shop-car.svg" alt="">
    </a>

    <div class="container">

        <?php

            include("../includes/header.php");

        ?>
    
        <section class="search">
            <form action="" method="GET">
                <span>Busca:</span>
                <input type="text" name="name_product" id="name_product" placeholder="Nome" maxlength="255">
                
                <select name="type_product" id="type_product">
                    <option value="" disabled selected>Selecione algo</option>
                    <?php
                        foreach ($product_types as $type) {
                            echo '<option value="'.$type['string'].'">'.ucfirst($type['string']).'</option>';
                        }
                    ?>
                </select>

                <div class="value">
                    <span>Preço:</span>
                    <input type="number" name="min_value_product" id="min_value_product" placeholder="min" min="0" max="999">
                    <input type="number" name="max_value_product" id="max_value_product" placeholder="max" min="0" max="999">
                </div>

                <input type="submit" value="Buscar">
            </form>
        </section>

        <section id="products">

        <?php
            $query = "SELECT * FROM products 
                    WHERE (LOWER(name_product) LIKE :search OR description_product LIKE LOWER(:search)) ";
            
            $search = '%%';
            if (isset($_GET['name_product'])) { 
                $search = '%'.strtolower(sanitizeString($_GET['name_product'])).'%';
            }

            if (isset($_GET['type_product'])) {
                $typeSearch = '%'.sanitizeString($_GET['type_product']).'%';
                if (!empty($typeSearch)) {
                    $query .= 'AND type_product LIKE :typeproduct ';   
                }
            }
            
            $minValue = '';
                if (isset($_GET['min_value_product'])) {
                    $minValue = sanitizeString($_GET['min_value_product']);
                    if (is_numeric($minValue)) {
                        $query .= 'AND price_product >= :min_value ';
                    }
                }

            $maxValue = '';
            if (isset($_GET['max_value_product'])) {
                $maxValue = sanitizeString($_GET['max_value_product']);
                if (is_numeric($maxValue)) {
                    $query .= 'AND price_product <= :max_value ';
                }
            }
            
            $stmt = $conn -> prepare($query);
            $stmt -> bindValue(':search', $search, PDO::PARAM_STR);

            if (!empty($typeSearch)) {
                $stmt -> bindValue(':typeproduct',$typeSearch);
            }

            if (is_numeric($minValue)) {
                $stmt -> bindValue(':min_value',$minValue);
            }

            if (is_numeric($maxValue)) {
                $stmt -> bindValue(':max_value',$maxValue);
            }
            
            $stmt -> execute();
            $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            foreach($return as $produto) {
                echo '<!-- Base Product --> 
                <div href="#" class="product">
                    <a href="product-page.php?id='.$produto['id_product'].'">
                        <img src="../images/';
                        if (empty($produto['photo_product']) || !file_exists('../images/'.$produto['photo_product']))
                            echo'missing-image.png';
                        else echo $produto['photo_product'];
                        echo'
                        " alt="">
                        <h1>'.ucfirst($produto['name_product']).'</h1>
                        <p>
                            '.ucfirst($produto['description_product']).'
                        </p>
                        
                        <div class="price-product">
                            R$ '.str_replace('.',',',$produto['price_product']).'
                        </div>
                        '.$produto['quantity_product'].' restantes
                    </a>

                    <div class="clear"></div>
                    
                    <a href="product-page.php?id='.$produto['id_product'].'" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                        </svg>

                        <span>Comprar</span>
                    </a>
                </div>
                <!-- End Base Product -->';
            }
        ?>

        </section>
        <?php

            include("../includes/footer.php");

        ?>
    </div>
</body>
</html>