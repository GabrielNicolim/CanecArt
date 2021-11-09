<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<a href='../public/views/login.php'>Voltar</a>";
    exit('Form not submited.');
}

require '../vendor/autoload.php';
require('db/connect.php');
require('functions.php');

$email = trim(filter_var($_POST['email']),FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //https://www.abstractapi.com/email-verification-validation-api
    //https://www.youtube.com/watch?v=JvGFlAK2fg4
    header("Location: ../public/views/recover.php?notice=invalidemail");
    exit;
}

$query = 'SELECT id_user, name_user FROM eq3.users WHERE email_user = :email';
$stmt = $conn -> prepare($query);
$stmt -> bindValue(':email', $email, PDO::PARAM_STR);
$stmt -> execute();

$return = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($stmt -> rowCount() > 0) {

    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null;
    }

    // Localweb desabilitou request file_get_contents 
    // $ipDetails = json_decode(file_get_contents("http://ip-api.com/json/{$ip}/"));

    if ( $ip == '::1') {
        $ip = 'Localhost';
        $city = '';
        $region = '';
        $country = '';
    } else {
        $ipDetails->ip = $ip;
        $ipDetails->city = $city;
        $ipDetails->region = $region;
        $ipDetails->country = $country;
    }

    $name_user = $return['name_user'];
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    $expires = date("U") + 3600; // 1 hour token validation in UNIX time

    $url = URLROOT.'/public/views/';
    $url .= 'new-password.php?selector=' . $selector . '&validator='. bin2hex($token);
    
    $query = 'INSERT INTO eq3.pwdreset(ip_pwdrequest, city_pwdrequest, region_pwdrequest, country_pwdrequest, selector_pwdrequest, token_pwdrequest, expires_pwdrequest, fk_email)
             VALUES(:ip, :city, :region, :country, :selector, :token, :expires, :fk_email)';
    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':ip', $ip, PDO::PARAM_STR);
    $stmt -> bindValue(':city', $city, PDO::PARAM_STR);
    $stmt -> bindValue(':region', $region, PDO::PARAM_STR);
    $stmt -> bindValue(':country', $country, PDO::PARAM_STR);
    $stmt -> bindValue(':selector', $selector, PDO::PARAM_STR);
    $stmt -> bindValue(':token', $hashedToken, PDO::PARAM_STR);
    $stmt -> bindValue(':expires', $expires);
    $stmt -> bindValue(':fk_email', $email, PDO::PARAM_STR);

    $stmt -> execute();

    if ($stmt) {

        require ('../public/includes/recover-mail.php');
        header('Content-Type: text/html; charset=UTF-8');

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
            $mail->addAddress($email, 'Caro usuário');             //Add a recipient
            $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = 'UTF-8';
            $mail->Subject = "CanecArt - Recuperação de senha";
            $mail->Body    = $mail_body;
            
            $mail->AltBody = $mail_AltBody;

            if (!$mail->send()) {  //echo 'Message has been sent';
                throw new Exception("Could not send message to email");
            } 

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            exit();
        }

        header("Location: ../public/views/recover.php?notice=success");
        exit;
    }

} else {
    header("Location: ../public/views/recover.php?notice=success");
    exit;
}
