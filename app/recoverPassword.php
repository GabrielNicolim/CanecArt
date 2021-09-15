<?php

require('db/connect.php');
require('functions.php');

$email = trim(filter_var($_POST['email']),FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //https://www.abstractapi.com/email-verification-validation-api
    //https://www.youtube.com/watch?v=JvGFlAK2fg4
    header("Location: ../public/views/recover.php?notice=invalidemail");
    exit;
}


$query = 'SELECT id_user, email_user FROM users WHERE email_user = :email';
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

    $ipDetails = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    
    if ( $ip == '::1') {
        $ipDetails->ip = 'Localhost';
        $ipDetails->city = '';
        $ipDetails->region = '';
        $ipDetails->country = '';
    }

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    $expires = date("U") + 3600; // 1 hour token validation in UNIX time

    $url = 'http://'.$_SERVER['HTTP_HOST'].'/canecart/public/views/';
    $url .= 'new-password.php?selector=' . $selector . '&validator='. bin2hex($token);
    
    $query = 'INSERT INTO pwdreset(ip_pwdrequest, city_pwdrequest, region_pwdrequest, country_pwdrequest, selector_pwdrequest, token_pwdrequest, expires_pwdrequest, fk_email)
             VALUES(:ip, :city, :region, :country, :selector, :token, :expires, :fk_email)';
    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':ip', $ipDetails->ip, PDO::PARAM_STR);
    $stmt -> bindValue(':city', $ipDetails->city, PDO::PARAM_STR);
    $stmt -> bindValue(':region', $ipDetails->region, PDO::PARAM_STR);
    $stmt -> bindValue(':country', $ipDetails->country, PDO::PARAM_STR);
    $stmt -> bindValue(':selector', $selector, PDO::PARAM_STR);
    $stmt -> bindValue(':token', $hashedToken, PDO::PARAM_STR);
    $stmt -> bindValue(':expires', $expires);
    $stmt -> bindValue(':fk_email', $email, PDO::PARAM_STR);

    $stmt -> execute();

    if ($stmt) {
        header("Location: ../public/views/recover.php?notice=success".$url);
        exit;
    }

} else {
    header("Location: ../public/views/recover.php?notice=success");
    exit;
}
