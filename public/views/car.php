<?php

    session_start();

    $page_title = 'Devs';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/car.css">',
                    '<link rel="stylesheet" href="../css/list.css">'];

    require("../includes/head.php");
    require("../../app/db/env.php");

?>
    
    <a href="car.php" class="shop-car">
        <img src="../icons/shop-car.svg" alt="">
    </a>

     <div class="container">

        <?php

            include("../includes/header.php");

        ?>
        
        <h2>Produtos</h2>

        <section id="car">

            <div class="left">
                <section class="list">

                    <div class="list-info">
                        <div class="list-name">Nome</div>
                        <div class="list-avalible">Estoque</div>
                        <div class="list-type">Tipo</div>
                        <div class="list-price">Preço</div>
                        <div class="list-interaction">Interação</div>
                    </div>

                    <!--Content of table-->
                    <?php

                        require("../../app/db/connect.php");

                        $query = "SELECT id_product, name_product, photo_product, price_product, type_product, quantity_product FROM products";
                        $stmt = $conn->prepare($query);
                        $stmt -> execute();

                        $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

                        if ($stmt -> rowCount() == 0) {
                            echo '<div class="list-item"><div class="list-name">Nenhum produto cadastrado!</div></div>';
                        } else {
                            foreach ($return as $product) {
                                echo '
                                <div class="list-item" id="'.$product['id_product'].'">
                                    <img class="image" src="../../images/';
                                    if (is_null($product['photo_product'])) echo 'missing-image.png'; else echo $product['photo_product'];
                                    echo '" alt="">
                                    <div class="list-name">'.$product['name_product'].'</div>
                                    <div class="list-avalible">'.$product['quantity_product'].'</div>
                                    <div class="list-type">'.$product['type_product'].'</div>
                                    <div class="list-price">'.$product['price_product'].'</div>
                                    <div class="list-interaction">
                                        <a href="">
                                            <img src="../../icons/eye-fill.svg" alt="">
                                        </a>
                                        <a href="">
                                            <img src="../../icons/pencil-square.svg" alt="">
                                        </a>
                                        <a href="">
                                            <img src="../../icons/trash-fill.svg" alt="">
                                        </a>
                                    </div>
                                </div>
                                ';
                            }
                        }
                
                    ?>

                </section>
        
            </div>

            <div class="right">
                <span>Resumo</span>

                <div class="price">
                    <span>Valor dos produtos:</span>
                    <span>R$ 1000</span>
                </div>

                <div class="buttons">
                    <div class="btn primary">Ir para o pagamento</div>
                    <div class="btn">Continuar Comprando</div>
                </div>
            </div>
        </section>
        
        <?php

            include("../includes/footer.php");

        ?>
    </div>
</body>
</html>