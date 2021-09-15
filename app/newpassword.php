<?php

require('db/connect.php');
require('functions.php');

$newpassword = filter_var($_POST['newpassword'], FILTER_SANITIZE_STRING);
$confirmPassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_STRING);
$selector = filter_var($_POST['selector'], FILTER_SANITIZE_STRING);
$token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);

if (empty($newpassword) || empty($confirmPassword) || empty($selector) || empty($token) || $newpassword !== $confirmPassword) {
    header("Location: ../public/views/new-password.php?notice=invaliddata");
    exit;
}

$query = 'SELECT * FROM pwdReset WHERE selector_pwdrequest = :selector';
$stmt = $conn -> prepare($query);
$stmt -> bindValue(':selector', $selector, PDO::PARAM_STR);
$stmt -> execute();

$return = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($stmt -> rowCount() > 0 && password_verify(hex2bin($token), $return['token_pwdrequest'])) {
    
    $query = 'UPDATE users SET password_user = :newpassword WHERE email_user = :email_user';
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':newpassword', password_hash($confirmPassword, PASSWORD_DEFAULT) , PDO::PARAM_STR);
    $stmt -> bindValue(':email_user', $return['fk_email'], PDO::PARAM_STR);
    $stmt -> execute();

    if ($stmt) {

        header("Location: ../public/views/login.php?notice=successchange");
        exit;

    }
    
}

header("Location: ../public/views/new-password.php?notice=errorupdating");
exit;

