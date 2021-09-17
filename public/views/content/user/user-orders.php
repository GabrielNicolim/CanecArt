<div class="top-menu">
    <a href="?page=data" class="btn">Perfil</a>
    <a href="?page=orders" class="btn activated">Pedidos</a>
    <a href="?page=config" class="btn">Configurações</a>
</div>

<div class="content">

    <section class="list">

        <!--Content of table-->
        <?php

            require("../../app/db/connect.php");

            $query = "SELECT id_product, name_product, photo_product, price_product, type_product, quantity_product FROM products";
            $stmt = $conn->prepare($query);
            $stmt -> execute();

            $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            if ($stmt -> rowCount() == 0) {
                echo '<div class="no-order"><div class="list-name">Nenhum Pedido Encontrado!</div></div>';
            } else {
                echo '
                    <div class="list-info">
                        <div class="list-name">Nome</div>
                        <div class="list-quantity">Quantidade</div>
                        <div class="list-type">Tipo</div>
                        <div class="list-price">Preço</div>
                        <div class="list-interaction">Interação</div>
                    </div>
                ';

                foreach ($return as $product) {
                    echo '
                    <div class="list-item" id="'.$product['id_product'].'">
                        <img class="image" src="../../images/';
                        if (is_null($product['photo_product'])) echo 'missing-image.png'; else echo $product['photo_product'];
                        echo '" alt="">
                        <div class="list-name">'.$product['name_product'].'</div>
                        <div class="list-quantity">'.$product['quantity_product'].'</div>
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