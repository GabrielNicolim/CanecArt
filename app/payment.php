<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../public/views/products.php");
    exit;
}

$id_adress = (int)filter_var($_POST['adress'], FILTER_SANITIZE_NUMBER_INT);

if (empty($id_adress) || !is_numeric($id_adress) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    exit;
}

require('db/connect.php');
require('functions.php');

$sql = 'SELECT *, (SELECT COUNT(*) FROM adresses WHERE id_adress = :id_adress AND fk_user = :session_user) FROM users WHERE id_user = :session_user';
$stmt = $conn -> prepare($sql);
$stmt -> bindValue(':id_adress', $id_adress, PDO::PARAM_STR);
$stmt -> bindValue(':session_user', $_SESSION['idUser'], PDO::PARAM_INT);
$stmt -> execute();

$user_data = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($user_data['count'] > 0) {
    
    $random_tracker = bin2hex(random_bytes(6));

    $sql = 'INSERT INTO orders(status_order, fk_user, fk_adress, track_order) 
            VALUES(\'AGUARDANDO PAGAMENTO\', :fk_user, :fk_adress, :track_order)';
    $stmt = $conn -> prepare($sql);
    $stmt -> bindValue(':fk_user', $_SESSION['idUser'], PDO::PARAM_INT);
    $stmt -> bindValue(':fk_adress', $id_adress, PDO::PARAM_STR);
    $stmt -> bindValue(':track_order', $random_tracker, PDO::PARAM_STR);
    $stmt -> execute();
    $id_order = $conn -> lastInsertID();

    foreach($_SESSION['cart'] as $product_id=>$quantity) {

        // Turn on PDO support for multiple queries
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);

        $sql = 'DO $$
                    DECLARE stock integer;
                BEGIN
                    SELECT quantity_product FROM products WHERE id_product = :fk_product INTO stock;
                
                    IF (stock >= :quantity_product) THEN
                        INSERT INTO order_products(fk_order, fk_product, quantity_product) 
                        VALUES(:fk_order, :fk_product, :quantity_product);
                    END IF;
                END $$;';

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':quantity_product', $quantity, PDO::PARAM_INT);
        $stmt -> bindValue(':fk_order', $id_order, PDO::PARAM_INT);
        $stmt -> bindValue(':fk_product', $product_id, PDO::PARAM_INT);

        $stmt -> execute();

        if (!$stmt) {
            $error = true;
        }
    }
    if (!isset($error)) {

        require '../vendor/autoload.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        try {
            //var_dump($user_data); exit;
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
            $mail->Subject = "CanecArt - Ordem de compra realizada!";
            $mail->Body    = "
            <html lang='pt-br'>
                <head>
                <meta charset='UTF-8'>
                    <style>
                        body{
                            width: 100%;
                            font-family: Roboto;
                            
                        }
                        #main{
                            width: 50%;
                            text-align: center;
                            margin: auto;
                            background-color: rgb(230, 230, 230);
                            min-width: 400px;
                        }
                        h1{
                            color: blue;
                        }
                        #top{
                            background: #144ff0;
                            color: white;
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
                        .texto{
                            text-align: justify; 
                            padding: 0 16px; 
                            font-size: 1.2em;
                        }
                    </style>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                </head>
                <body>
                <div id='main'>
                <div id='top'height='70px' width='100%'>
                    <h2 style='padding-top: 30px; padding-bottom: 30px;'>CanecArt</h2>
                </div>
                <h1>Ordem de compra - Canecart</h1>
                    <p class='texto'>
                    Olá $user_data[name_user], nós recebemos sua ordem de compra da sua conta em nosso site, agora só falta fazer o pagamento para os
                    produtos abaixos:<br>";
                    foreach ($_SESSION['cart'] as $product_id=>$quantity) {
                        $mail->Body .= 'Produto id ='.$product_id.' x'.$quantity;
                    }

                    $mail->Body .= "O boleto ficará disponível por até 3 dias após o envio desse email para pagamento
                    </p><br>
                    <a> <button>Pagar</button> </a>
                    <br>

                </div>
                </body>
            </html>
            ";
            
            $mail->AltBody = 'mail_AltBody';

            if (!$mail->send()) {  //echo 'Message has been sent';
                throw new Exception("Could not send message to email");
            } 

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            exit();
        }

        unset($_SESSION['cart']); 
        echo "Sucess";
    }
    
} else {
    exit;
}
