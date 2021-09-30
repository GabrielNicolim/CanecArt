<div class="top-menu">
    <a href="?page=data" class="btn">Perfil</a>
    <a href="?page=orders" class="btn activated">Pedidos</a>
    <a href="?page=adresses" class="btn">Endereços</a>
    <a href="?page=config" class="btn">Configurações</a>
</div>

<div class="content">

    <section class="list">

        <!--Content of table-->
        <?php

            require("../../app/db/connect.php");

            $query = "SELECT id_order, status_order, track_order, id_product, name_product, photo_product, description_product,
                        price_product, type_product, deleted, order_products.quantity_product, id_adress, contact_adress,
                        state_adress, district_adress 
                    FROM orders 
                        INNER JOIN order_products ON fk_order = id_order
                        INNER JOIN products ON id_product = fk_product
                        INNER JOIN adresses ON id_adress = fk_adress
                    WHERE orders.fk_user = :id_session";

            $stmt = $conn->prepare($query);
            $stmt -> bindValue(':id_session', $_SESSION['idUser'], PDO::PARAM_INT);
            $stmt -> execute();

            $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            if ($stmt -> rowCount() == 0) {
                echo '<div class="no-order"><div class="list-name">Nenhum Pedido Encontrado!</div></div>';
            } else {
                echo '
                <div class="list-info">
                    <div class="list-id">#ID Pedido</div>
                    <div class="list-name">Produtos</div>
                    <div class="list-quantity">Quantidade</div>
                    <div class="list-price">Valor</div>
                    <div class="list-type">Status</div>
                </div>';

                $id_order = 0;
                foreach ($return as $product) {
                    //var_dump($product);
                    // Means it's the first product of an order
                    if ($id_order != $product['id_order']) {
                        echo '<div class="list-item order-header" id="'.$product['id_order'].'">
                                <div class="list-id">Pedido: #'.$product['id_order'].'</div>
                                <div class="list-name">Caneca Goku branca 325ml, Caneca bulbassauro com X a as </div>
                                <div class="list-quantity">'.$product['quantity_product'].'</div>
                                <div class="list-price">R$ '.floatval($product['price_product']*$product['quantity_product']).'</div>
                                <div class="list-type">AGUARDANDO PAGAMENTO</div>
                            </div>';

                    }
                    // Means that it's another product of the same order
                    //var_dump($product);
                    echo '
                    <div class="list-item" id="'.$product['id_product'].'">
                    <div class="list-id">
                        <img class="image" src="../images/';
                        if (is_null($product['photo_product'])) echo 'missing-image.png'; else echo $product['photo_product'];
                        echo '" alt="Foto do produto">
                        </div>
                        <div class="list-name">'.$product['name_product'].'</div>
                        <div class="list-quantity">'.$product['quantity_product'].'</div>
                        <div class="list-price">'.$product['price_product'].'<br>(Unidade)</div>
                        <div class="list-type">
                            Cód Rastreio:<br>    
                            '.strtoupper($product['track_order']).'
                        </div>
                    </div>
                    ';

                    $id_order = $product['id_order'];
                }
            }
            
        ?> 
        
    </section>
</div>