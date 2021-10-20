<?php

    session_start();

    if (!isset($_SESSION['isAuth']) && $_SESSION['idUser'] != -1) {
        header("Location: ../login.php");
        exit();
    }

    $page_title = 'Produtos - Admin';
    $icon_folder = '../../images/logos/favicon.png';

    $style_scripts = ['<script src="../../../js/admin.js"></script>',
                    '<link rel="stylesheet" href="../../css/style.css">',
                    '<link rel="stylesheet" href="../../css/admin.css">',
                    '<link rel="stylesheet" href="../../css/list.css">'];

    require("../../includes/head.php");
    require("../../../app/db/connect.php");
    require("../../../app/functions.php");

    $query = 'SELECT DISTINCT type_product FROM eq3.products';

    $stmt = $conn -> prepare($query);
    $stmt -> execute();
    $product_types = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    $type = (!empty($_GET['type_product'])) ? $_GET['type_product'] : '';
    $search = (!empty($_GET['name_product'])) ? $_GET['name_product'] : '';
    
?>
    <div class="container">
        <!--Header-->
        <header id="top">
            <div class="content">
                <a href="home-admin.php" class="logo">
                    Administrador
                </a>
        
                <nav>
                    <a href="home-admin.php" class="btn">Home</a>
                    <a href="products-admin.php" class="btn active">Produtos</a>
                    <a href="peoples-admin.php" class="btn">Pessoas</a>
                    <a href="#Estatics-admin" class="btn">Estatísticas</a>
                </nav> 
            </div> 
        </header>

        <!--Produtos-->
        <section class="search">
            <form action="" method="GET">
                <span>Busca:</span>
                <input type="text" name="name_product" id="name_product" placeholder="Nome" value="<?= $search ?>">
                
                <select name="type_product" id="type_product">
                    <option value="" disabled selected>Selecione algo</option>
                    <?php
                        foreach ($product_types as $types) {
                            echo '<option value="'.$types["type_product"].'">'.ucfirst($types["type_product"]).'</option>';
                        }
                    ?>
                </select>

                <div class="value">
                    <span>Preço:</span>
                    <input type="number" name="min_value_product" id="min_value_product" placeholder="min" 
                    min="0" step="0.01" max="999">
                    <input type="number" name="max_value_product" id="max_value_product" placeholder="max" 
                    min="0" step="0.01" max="999">
                </div>

                <input type="submit" value="Buscar">
            </form>

            <a href="insert-products-admin.php" class="btn insert">Inserir Produto</a>
        </section>
        
        <section class="list">
            <div class="list-info">
                <div class="list-name">Nome</div>
                <div class="list-avalible">Estoque</div>
                <div class="list-type">Tipos</div>
                <div class="list-price">Preço</div>
                <div class="list-interaction">Interação</div>
            </div>

            <!--Content of table-->
            <?php

                $query = 'SELECT id_product, name_product, photo_product, price_product, type_product, quantity_product, deleted
                          FROM eq3.products
                          WHERE (LOWER(name_product) LIKE :nameproduct OR LOWER(description_product) LIKE :nameproduct) ';

                $nameSearch = '%%';
                if (isset($_GET['name_product'])) { 
                    $nameSearch = '%'.strtolower(sanitizeString($_GET['name_product'])).'%';
                }

                if (isset($_GET['type_product'])) {
                    $typeSearch = sanitizeString($_GET['type_product']);
                    if (!empty($typeSearch)) {
                        $query .= 'AND type_product = :typeproduct ';   
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

                $stmt = $conn->prepare($query);
                $stmt -> bindValue(':nameproduct',$nameSearch);

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

                if ($stmt -> rowCount() == 0) {
                    echo '<div class="list-item"><div class="list-name">Nenhum produto cadastrado!</div></div>';
                } else {
                    foreach ($return as $product) {
                        echo '
                        <div class="list-item '; if($product['deleted']) echo 'item-deleted'; echo '" id="'.$product['id_product'].'">
                            <img class="image" src="../../images/';
                            if (empty($product['photo_product'])) echo 'missing-image.png'; else echo $product['photo_product'];
                            echo '" alt="Foto do produto">
                            <div class="list-name">'.$product['name_product'].'</div>
                            <div class="list-avalible">'.$product['quantity_product'].'</div>
                            <div class="list-type">'.$product['type_product'].'</div>
                            <div class="list-price">'.$product['price_product'].'</div>
                            <div class="list-interaction">
                                <a href="../product-page.php?id='.$product['id_product'].'">
                                    <img src="../../icons/eye-fill.svg" alt="Icone para acessar o produto">
                                </a>
                                <a href="edit-product.php?product='.$product['id_product'].'">
                                    <img src="../../icons/pencil-square.svg" alt="Icone para editar o produto">
                                </a>';
                                if ($product['deleted']) {
                                    echo '<a href="../../../app/deleteProducts.php?delete='.$product['id_product'].'&status=0">
                                        <img src="../../icons/trash-restore-solid.svg" alt="Icone para deletar produto">
                                    </a>';
                                } else {
                                    echo '<a href="../../../app/deleteProducts.php?delete='.$product['id_product'].'&status=1" >
                                        <img src="../../icons/trash-fill.svg" alt="Icone para restaurar produto">
                                    </a>';
                                }                            
                                echo'
                            </div>
                        </div>
                        ';
                    }
                }
                
            ?>
        </section>
    </div>
</body>
</html>