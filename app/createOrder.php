<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../public/views/products.php");
    exit;
}

$id_adress = (int)filter_var($_POST['adress'], FILTER_SANITIZE_NUMBER_INT);

if (empty($id_adress) || !is_numeric($id_adress) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0 || $_SESSION['idUser'] < 0) {
    exit;
}

require('db/connect.php');
require('functions.php');

$sql = 'SELECT *
        FROM eq3.users 
        INNER JOIN eq3.adresses on id_adress = :id_adress AND fk_user = :session_user
        WHERE id_user = :session_user';
$stmt = $conn -> prepare($sql);
$stmt -> bindValue(':id_adress', $id_adress, PDO::PARAM_STR);
$stmt -> bindValue(':session_user', $_SESSION['idUser'], PDO::PARAM_INT);
$stmt -> execute();

$user_data = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($stmt -> rowCount() > 0) {
    
    $adress_backup = $user_data['cep_adress'] . ' - ' . $user_data['state_adress'] . ', ' . 
                     $user_data['city_adress'] . ', ' . $user_data['district_adress'] . ', ' . 
                     $user_data['street_adress'] . ', ' . $user_data['number_adress'] . ', ' .
                     $user_data['complement_adress'];

    $sql = 'INSERT INTO eq3.orders(backup_adress_order, contact_order, fk_user, fk_adress) 
            VALUES(:adress_backup, :contact, :fk_user, :fk_adress)';
    $stmt = $conn -> prepare($sql);
    $stmt -> bindValue(':adress_backup', $adress_backup, PDO::PARAM_STR);
    $stmt -> bindValue(':contact', $user_data['contact_adress'], PDO::PARAM_STR);
    $stmt -> bindValue(':fk_user', $_SESSION['idUser'], PDO::PARAM_INT);
    $stmt -> bindValue(':fk_adress', $id_adress, PDO::PARAM_STR);

    $stmt -> execute();
    $id_order = $conn -> lastInsertID();

    foreach($_SESSION['cart'] as $product_id=>$quantity) {

        // Will activate the update_stock() function that verifies the amount to X in stock
        // and if there is not enough, it will return false and the order will not be registered
        $sql = 'INSERT INTO eq3.order_products(fk_order, fk_product, quantity_product, price_backup) 
                VALUES(:fk_order, :fk_product, :quantity_product, 
                (SELECT price_product FROM eq3.products WHERE id_product = :fk_product) ) ON CONFLICT DO NOTHING';

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':fk_order', $id_order, PDO::PARAM_INT);
        $stmt -> bindValue(':fk_product', $product_id, PDO::PARAM_INT);
        $stmt -> bindValue(':quantity_product', $quantity, PDO::PARAM_INT);

        $stmt -> execute();

        if (!$stmt || $stmt->RowCount() == 0) {
            echo 'ERROR';
            exit;
        }
    }

    $query = "SELECT id_order, status_order, track_order, date_order, id_product, name_product, photo_product, description_product,
                    price_product, type_product, products.deleted, eq3.order_products.quantity_product, id_adress, contact_adress,
                    state_adress, district_adress 
                FROM eq3.orders 
                    INNER JOIN eq3.order_products ON fk_order = id_order
                    INNER JOIN eq3.products ON id_product = fk_product
                    INNER JOIN eq3.adresses ON id_adress = fk_adress
                WHERE orders.fk_user = :id_session AND orders.id_order = :id_order";

    $stmt = $conn->prepare($query);
    $stmt -> bindValue(':id_session', $_SESSION['idUser'], PDO::PARAM_INT);
    $stmt -> bindValue(':id_order', $id_order, PDO::PARAM_INT);
    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    $aux = 0;
    $order_values = [];
    $order_quantity = [];
    foreach ($return as $product) {
        if ($aux != $product['id_order']) {
            $order_values[$product['id_order']] = floatval($product['price_product']*$product['quantity_product']);
            $order_quantity[$product['id_order']] = $product['quantity_product'];
        } else {
            $order_values[$product['id_order']] += floatval($product['price_product']*$product['quantity_product']);
            $order_quantity[$product['id_order']] += $product['quantity_product'];
        }
        $aux = $product['id_order'];
    }

    require '../vendor/autoload.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    try {
        //Server settings
        $mail->isSMTP();                                        //Send using SMTP
        $mail->Host       = PHPMAILER_INFO['smtp_host'];        //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                               //Enable SMTP authentication
        $mail->Username   = PHPMAILER_INFO['mail_user'];        //SMTP username
        $mail->Password   = PHPMAILER_INFO['password_user'];    //SMTP password
        $mail->SMTPSecure = $mail::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = PHPMAILER_INFO['mail_port'];        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom(PHPMAILER_INFO['mail_user'], 'CanecArt');
        $mail->addAddress($user_data['email_user'], 'Caro usuário');             //Add a recipient
        $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "CanecArt - O pedido #".$id_order." está aguardado seu pagamento";
        $mail->Body    = '<!DOCTYPE html>
        <html lang="pt-br">
            <head>
            <meta charset="UTF-8">
                <style>
                    body{width: 100%;margin: 0;padding: 0;font-family: Roboto;}
                    #main{
                        width: 100%;
                        background-color: rgb(230, 230, 230);
                        min-width: 400px;
                        text-align: justify; 
                        padding: 1em; 
                        font-size: 1.2em;
                    }
                    h1{
                        color: blue;
                    }
                    #top{
                        background: #144ff0;
                        color: white;
                        height: 70px;
                        width: 100%;
                        text-align: center;
                    }
                    .products {
                        width: 90%;
                    }
                    button{
                        background-color:black;
                        color: white;
                        font-size: 1.5em; 
                        cursor: pointer;
                        padding: 1em;
                        outline: none;
                        border-radius: .5em;
                        border: none;
                    }
                    .list-info {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        background: #144ff0;
                        padding: 1em 1em 1em 1.85em;
                        color: #FFF;
                        border-radius: 1em 1em 0 0;
                        font-weight: 700;
                    }
                    .order-header {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding: 1em;
                        font-weight: 500;
                        background: rgb(224, 224, 224);
                        border: 2px solid rgb(151, 151, 151);
                    }
                    .list-item {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding: 1em;
                        background: white;
                        font-weight: 500;
                    }
                    .list-item .image {
                        width: 80px;
                        border: 1px solid black;
                        float: left;
                    }
                    .list-state, .list-id {
                        text-align: center;
                    }
                    .list-name {
                        width: 100%;
                        text-align: center;
                    }
                    .list-quantity, .list-avalible, .list-type, .list-price, .list-interaction {
                        width: 300px;
                        text-align: center;
                    }           
                </style>
                <meta http-equiv="Content-Type" content="text/html charset=utf-8" />
            </head>
            <body>
            <div id="top">
                <h2 style="padding-top: 30px; padding-bottom: 30px;">CanecArt</h2>
            </div>
            <div id="main">
                <h1>Ordem de compra - Canecart</h1>
                <p>Olá '.$user_data['name_user'].', nós recebemos sua ordem de compra da sua conta em nosso site, agora só falta fazer o pagamento para os
                produtos abaixos:<br></p>
                <div class="products">
                <div class="list-info">
                    <div class="list-id">#ID Pedido</div>
                    <div class="list-name">Produtos</div>
                    <div class="list-quantity">Quantidade</div>
                    <div class="list-price">Valor</div>
                    <div class="list-type">Status</div>
                </div>';     

                $aux = 0;
                foreach ($return as $key=>$product) {
                    // Means it's the first product of an order
                    if ($aux != $product['id_order']) {
                        $myDateTime = DateTime::createFromFormat('Y-m-d', $product['date_order']);

                        $mail->Body .= '<div class="order-header" id="'.$product['id_order'].'">
                                <div class="list-id">Pedido: #'.$product['id_order'].'<br>'.$myDateTime->format('d/m/Y').'</div>
                                <div class="list-name"></div>
                                <div class="list-quantity">Total:<br>'.$order_quantity[$product['id_order']].'</div>
                                <div class="list-price">Total:<br>R$ '.$order_values[$product['id_order']].'</div>
                                <div class="list-type">'.$product['status_order'].'</div>
                            </div>';

                    }
                    // Means that it's another product of the same order
                    $mail->Body .= '
                    <div class="list-item" id="'.$product['id_product'].'">
                        <div class="list-id">';
                        // To send images to a modern mailer we need to embedded the image and use it as a CDI: in the img tag
                        if (is_null($product['photo_product'])) {
                            $mail->AddEmbeddedImage('../public/images/missing-image.png', 'image'.$product['id_product']); 
                        } else {
                            $mail->AddEmbeddedImage('../public/images/'.$product['photo_product'], 'image'.$product['id_product']); 
                        }

                        $mail->Body .='<img class="image" alt="Foto do produto"  src="cid:image'.$product['id_product'].'">
                        </div>
                        <div class="list-name"><a href="'.URLROOT.'/public/views/product-page.php?id='.$product['id_product'].'" >'.$product['name_product'].'</a></div>
                        <div class="list-quantity">x'.$product['quantity_product'].'</div>
                        <div class="list-price">'.$product['price_product'].'<br>(Unidade)</div>
                        <div class="list-type">';
                            if ($product['status_order'] == 'AGUARDANDO PAGAMENTO'){
                                $mail->Body .= 'Para:<br>'.ucfirst($product['contact_adress']).' em '.$product['state_adress'].'-'.$product['district_adress'];
                            } else {
                                $mail->Body .= 'Cód Rastreio:<br>'.strtoupper($product['track_order']);
                            }
                            $mail->Body .='
                        </div>
                    </div>
                    ';

                    $aux = $product['id_order'];
                }

                $mail->Body .= "</div><p>O boleto ficará disponível por até 3 dias após o envio desse email para pagamento</p><br>
                <a href='".URLROOT."/public/views/user.php?page=orders'><button>Pagar</button></a>
                <br>

            </div>
            </body>
        </html>";
        $mail->AltBody = 'Olá '.$user_data['name_user'].', nós recebemos sua ordem de compra da sua conta em nosso site, agora só falta fazer o pagamento para os
        produtos abaixos:<br>
        O HTML do seu provedo de email está desativado então visite o site para ver os produtos da sua ordem!<br>
        O boleto ficará disponível por até 3 dias após o envio desse email para pagamento
        Link = '.URLROOT.'/public/views/user.php?page=orders"';

        if (!$mail->send()) {
            throw new Exception("Could not send message to email");
        } 

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        exit();
    }

    unset($_SESSION['cart']); 
    echo "Sucess";
    
} else {
    echo 'ERROR';
    exit;
}