<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<a href='../public/views/login.php'>Voltar</a>";
    exit('Form not submited.');
}

require('db/connect.php');
require('functions.php');

$newpassword = sanitizeString($_POST['newpassword']);
$confirmPassword = sanitizeString($_POST['confirmpassword']);
$selector = sanitizeString($_POST['selector']);
$token = sanitizeString($_POST['token']);

if (empty($newpassword) || empty($confirmPassword) || empty($selector) || empty($token) || $newpassword != $confirmPassword) {
    header("Location: ../public/views/new-password.php?selector=$selector&validator=$token&notice=invaliddata");
    exit;
}

if (!validatePassword($newpassword)) {
    header("Location: ../public/views/new-password.php?selector=$selector&validator=$token&notice=weakpassword");
    exit;
}

$query = 'SELECT token_pwdrequest, fk_email FROM eq3.pwdReset WHERE selector_pwdrequest = :selector';
$stmt = $conn -> prepare($query);
$stmt -> bindValue(':selector', $selector, PDO::PARAM_STR);
$stmt -> execute();

$return = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($stmt -> rowCount() > 0 && password_verify(hex2bin($token), $return['token_pwdrequest'])) {
    
    $query = 'UPDATE eq3.users SET password_user = :newpassword WHERE email_user = :email_user';
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':newpassword', password_hash($confirmPassword, PASSWORD_DEFAULT) , PDO::PARAM_STR);
    $stmt -> bindValue(':email_user', $return['fk_email'], PDO::PARAM_STR);
    $stmt -> execute();

    $query = 'DELETE FROM eq3.pwdReset WHERE fk_email = :email_user';
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':email_user', $return['fk_email'], PDO::PARAM_STR);
    $stmt -> execute();

    if ($stmt) {

        header("Location: ../public/views/login.php?notice=successchange");
        exit;

    }
    
}

header("Location: ../public/views/new-password.php?notice=errorupdating");
exit;

