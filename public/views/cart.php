<?php

    session_start();

    $page_title = 'Carrinho';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/cart.css">',
                    '<link rel="stylesheet" href="../css/adresses.css">',
                    '<link rel="stylesheet" href="../css/list.css">',
                    '<script src="../../js/cart.js"></script>'];

    require("../includes/head.php");
    require("../../app/db/connect.php");
    require("../../app/functions.php");

    if (isset($_GET['add_product'])) {
        $id_product = intval(sanitizeString($_GET['add_product']));
        if (!empty($id_product)) {
            if (isset($_SESSION['cart'][$id_product])) {
                $_SESSION['cart'][$id_product] += 1;
            } else {
                $_SESSION['cart'][$id_product] = 1;
            }
        }
    }

    if (isset($_GET['remove_product'])) {

    }

    var_dump($_SESSION['cart']);
?>
    
    <a href="cart.php" class="shop-car">
        <img src="../icons/shop-car.svg" alt="">
    </a>

     <div class="container">

        <?php

            include("../includes/header.php");

        ?>
        
        <h2>Carrinho</h2>

        <section id="car">

            <div class="left">
                <section class="list">

                    <div class="list-info">
                        <div class="list-name">Nome</div>
                        <div class="list-avalible">Disponibilidade</div>
                        <div class="list-price">Preço</div>
                        <div class="list-interaction">Quantidade</div>
                    </div>

                    <!--Content of table-->
                    <?php
                        $final_value = 0;

                        if (!isset($_SESSION['cart'])) {
                            echo '<div class="list-item"><div class="list-name">Nenhum produto cadastrado!</div></div>';
                        } else {
                            echo '<form method="GET" action"">';
                            foreach($_SESSION['cart'] as $id_product => $quantity) {
                                
                                var_dump($id_product);
                            
                                $query = "SELECT id_product, name_product, photo_product, price_product, quantity_product FROM products WHERE id_product = :id_product";
                                $stmt = $conn->prepare($query);
                                $stmt -> bindValue(':id_product', $id_product, PDO::PARAM_INT);
                                $stmt -> execute();

                                $product = $stmt -> fetch(PDO::FETCH_ASSOC);
                                    
                                echo '
                                <div class="list-item" id="'.$product['id_product'].'">
                                    <img class="image" src="../images/';
                                    if (empty($product['photo_product'])) echo 'missing-image.png'; else echo $product['photo_product'];
                                    echo '" alt="">
                                    <div class="list-name"><a href="product-page.php?id='.$product['id_product'].'">'.$product['name_product'].'</a></div>
                                    <div class="list-avalible">'.$product['quantity_product'].'</div>
                                    <div class="list-price">'.$product['price_product'].'</div>
                                    <div class="list-interaction">
                                        <input type="number" min="0" name="update'.$product['id_product'].'" value="'.$quantity.'" style="width:3em;">
                                        <a href="">
                                            <img src="../icons/trash-fill.svg" alt="">
                                        </a>
                                    </div>
                                </div>
                                ';
                                $final_value += $product['price_product'];    

                            }
                            echo '<button type="submit">atualizar carrinho</button>
                            </form>';
                        }
                    ?>

                </section>

                <h2>Escolher endereço</h2>
                <div class="adresses">
                    
                <?php

                    if (!isset($_SESSIOn['idUser'])) {

                        $query = "SELECT * FROM adresses WHERE fk_user = :session_id";

                        $stmt = $conn -> prepare($query);
                        $stmt -> bindValue(':session_id', $_SESSION['idUser'], PDO::PARAM_INT);

                        $stmt -> execute();

                        $result = $stmt -> fetchALL(PDO::FETCH_ASSOC);

                        if ($stmt -> rowCount() == 0)
                            echo '<div class="adress_box"><h1>Nenhum endereço cadastrado no momento</h1></div>';
                        foreach($result as $adress) {
                            echo '<div class="adress_box">
                            <div class="adress_top">
                            <i class="fas fa-address-book"></i>
                                '.$adress['contact_adress'].'
                            </div>
                            <div class="adress_body">
                                CEP: '.$adress['cep_adress'].', '.$adress['city_adress'].', '.$adress['state_adress'].'<br>
                                Bairro '.$adress['district_adress'].',<br>
                                '.$adress['street_adress'].',
                                Numero '.$adress['number_adress'].',<br>
                                Complemento: '.$adress['complement_adress'].'
                            </div>
                            <div class="footer">
                                <a href="../../app/deleteAdresses.php?delete='.$adress['id_adress'].'"><i class="fas fa-trash-alt"></i> Excluir</a>
                            </div>
                            </div>';
                        }
                    }
                ?>
                </div>
            </div>

            <div class="right">
                <span>Resumo</span>

                <div class="price">
                    <span>Valor dos produtos:</span>
                    <span>R$ <?=$final_value?></span>
                </div>

                <div class="buttons">
                    <a href="#"><div class="btn primary">Ir para o pagamento</div></a>
                    <a href="products.php"><div class="btn">Continuar Comprando</div></a>
                </div>
            </div>
        </section>
        
        <?php

            include("../includes/footer.php");

        ?>
    </div>
</body>
</html>