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

            $query = "SELECT id_order, status_order, backup_adress_order, contact_order,track_order, date_order, id_product, name_product, 
                        photo_product, description_product, price_product, type_product, products.deleted, eq3.order_products.quantity_product
                    FROM eq3.orders 
                        INNER JOIN eq3.order_products ON fk_order = id_order
                        INNER JOIN eq3.products ON id_product = fk_product
                    WHERE orders.fk_user = :id_session ORDER BY id_order DESC";

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
                $order_values = [];
                $order_quantity = [];
                foreach ($return as $product) {
                    if ($id_order != $product['id_order']) {
                        $order_values[$product['id_order']] = floatval($product['price_product']*$product['quantity_product']);
                        $order_quantity[$product['id_order']] = $product['quantity_product'];
                    } else {
                        $order_values[$product['id_order']] += floatval($product['price_product']*$product['quantity_product']);
                        $order_quantity[$product['id_order']] += $product['quantity_product'];
                    }
                    $id_order = $product['id_order'];
                }

                $id_order = 0;
                foreach ($return as $key=>$product) {
                    // Means it's the first product of an order
                    if ($id_order != $product['id_order']) {
                        echo '<div class="list-item order-header" id="'.$product['id_order'].'">
                                <div class="list-id">Pedido: #'.$product['id_order'].'<br>'.translateDate($product['date_order']).'</div>
                                <div class="list-name">'; if($product['status_order'] == "AGUARDANDO PAGAMENTO") echo '<button id="'.$product['id_order'].'">Pagar agora</button>'; echo '</div>
                                <div class="list-quantity">Total:<br>'.$order_quantity[$product['id_order']].'</div>
                                <div class="list-price">Total:<br>R$ '.$order_values[$product['id_order']].'</div>
                                <div class="list-type">';
                                if ($product['track_order'] == null){
                                    echo 'Enviar para:<br>'.ucfirst($product['contact_order']).' em '.$product['backup_adress_order'];
                                } else {
                                    echo 'Cód Rastreio:<br>'.strtoupper($product['track_order']);
                                }
                                
                            echo'</div>
                            </div>';

                    }
                    // Means that it's another product of the same order
                    echo '
                    <div class="list-item" id="'.$product['id_product'].'">
                    <div class="list-id">
                        <img class="image" src="../images/';
                        if (is_null($product['photo_product'])) echo 'missing-image.png'; else echo $product['photo_product'];
                        echo '" alt="Foto do produto">
                        </div>
                        <div class="list-name"><a href="product-page.php?id='.$product['id_product'].'" >'.$product['name_product'].'</a></div>
                        <div class="list-quantity">x'.$product['quantity_product'].'</div>
                        <div class="list-price">'.$product['price_product'].'<br>(Unidade)</div>
                        <div class="list-type">'.$product['status_order'].'</div>
                    </div>';

                    $id_order = $product['id_order'];
                }
            }
            
        ?> 
        
    </section>
    <script src="../../js/orders.js"></script>
</div>