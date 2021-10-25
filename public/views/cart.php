<?php

    session_start();

    if (!isset($_SESSION['idUser'])) {
        header('Location: login.php');
        exit;
    }

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

                    <div id="empty"></div>
                    
                    <!--Content of table-->
                    <?php
                        $final_value = 0;

                        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                            echo '<div class="list-item"><div class="list-name">
                            Nenhum produto no carrinho.
                            <a href="products.php">Vamos as compras!</a>
                            </div></div>';
                        } else {
                            foreach($_SESSION['cart'] as $id_product => $quantity) {
                            
                                $query = "SELECT id_product, name_product, photo_product, price_product, quantity_product FROM eq3.products WHERE id_product = :id_product";
                                $stmt = $conn->prepare($query);
                                $stmt -> bindValue(':id_product', $id_product, PDO::PARAM_INT);
                                $stmt -> execute();

                                $product = $stmt -> fetch(PDO::FETCH_ASSOC);
                                    
                                if($product['quantity_product'] != 0) {
                                    $class = 'list-item';
                                    $text = $product['quantity_product'];
                                } else {
                                    $class = 'list-item out';
                                    $text = 'Produto Indisponível';
                                }

                                echo '
                                <div class="'.$class.'" id="'.$product['id_product'].'">
                                    <img class="image" src="../images/';
                                    if (empty($product['photo_product'])) echo 'missing-image.png'; else echo $product['photo_product'];
                                    echo '" alt="Imagem do produto">
                                    <div class="list-name"><a href="product-page.php?id='.$product['id_product'].'">'.$product['name_product'].'</a></div>
                                    <div class="list-avalible">'.$text.'</div>
                                    <div class="list-price">'.$product['price_product'].'</div>
                                    <div class="list-interaction">
                                        <input type="number" class="input-quantity" min="0" name="update'.$product['id_product'].'" value="'.$quantity.'">
                                        <img src="../icons/trash-fill.svg" id='.$product['id_product'].'" alt="Excluir produto">
                                    </div>
                                </div>
                                ';
                                $final_value += $product['price_product']*$_SESSION['cart'][$product['id_product']];    

                            }
                            echo '<a href="?"><button type="submit" id="update">Atualizar Carrinho</button></a>';
                        }
                    ?>

                </section>
    
                <?php
                    echo '<h2>Escolher endereço</h2>
                    <div class="adresses">';

                    $query = "SELECT * FROM eq3.adresses WHERE fk_user = :session_id AND deleted = false";

                    $stmt = $conn -> prepare($query);
                    $stmt -> bindValue(':session_id', $_SESSION['idUser'], PDO::PARAM_INT);

                    $stmt -> execute();

                    $result = $stmt -> fetchALL(PDO::FETCH_ASSOC);

                    if ($stmt -> rowCount() == 0)
                        echo '<div class="adress_box"><h1>Nenhum endereço cadastrado no momento</h1>
                        <a href="user.php?page=adresses"><button id="add-adress">
                            <i class="fas fa-plus"></i>
                            <span>Adicionar Endereço</span>
                        </button></a>
                        </div>';
                    foreach($result as $key=>$adress) {
                        echo '<div class="adress_box" id="'.$adress['id_adress'].'">
                        <div class="adress_top">
                        <i class="fas fa-address-book"></i>
                            '.$adress['contact_adress'].' <input type="radio" name="choosen" '; if ($key == 0) echo 'checked'; echo'>
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
                    echo '</div>';
                ?>
                
            </div>

            <div class="right">
                <span>Resumo</span>

                <div class="price">
                    <span>Valor dos produtos:</span>
                    <span id="total-price">R$ <?=$final_value?></span>
                </div>

                <div class="buttons">
                    <a  id="payment_button"><div class="btn primary">
                        Ir para o pagamento
                    </div></a>
                    <a href="products.php"><div class="btn">Continuar Comprando</div></a>
                </div>
                
                <div id="error-out" class="hidden">
                    Você tem produtos que estão fora do estoque no seu carrinho
                </div>  
            </div>
        </section>

        <div id="opacity" class="hidden">
            <img id="loading" src="../images/loading-buffering.gif" width="300px">
        </div>
        
        <?php

            include("../includes/footer.php");

        ?>
    </div>
</body>
</html>