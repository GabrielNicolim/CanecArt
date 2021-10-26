<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../public/views/products.php");
    exit;
}

require('db/connect.php');
require('functions.php');

$name = sanitizeString($_POST['name']);
$email = sanitizeString($_POST['email']);

if (!empty($name) && !empty($email)) {

    $query = 'SELECT COUNT(*) FROM eq3.users WHERE email_user = :email_user AND id_user != :id_user';
    $stmt = $conn -> prepare($query);
    $stmt -> execute([$email, $_SESSION['idUser']]);
    $emailcheck = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($emailcheck['count'] > 0) {
        header("Location: ../public/views/user.php?page=config&notice=emailregistered");
        exit;
    }

    $query = 'UPDATE eq3.users SET name_user = :name_user, email_user = :email_user WHERE id_user = :id_user';

    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':name_user', ucwords($name), PDO::PARAM_STR);
    $stmt -> bindValue(':email_user', $email, PDO::PARAM_STR);
    $stmt -> bindValue(':id_user', $_SESSION['idUser'], PDO::PARAM_INT);

    $stmt -> execute();

    if ($stmt -> rowCount() > 0) {
        header("Location: ../public/views/user.php?page=config&notice=sucess");
        exit;
    } else {
        header("Location: ../public/views/user.php?page=config&notice=error");
        exit;
    }

}