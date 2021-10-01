<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SERVER['REQUEST_METHOD'] != 'GET') {
    header("Location: ../public/views/products.php");
    exit;
}

require('db/connect.php');
require('functions.php');

$product_id = sanitizeString($_GET['delete']);

//var_dump($status); exit;
if (empty($product_id) || !is_numeric($product_id)) {
    header("Location: ../public/views/admin/products-admin.php?notice=error");
    exit;
}

$query = "UPDATE adresses SET deleted = True WHERE id_adress = :id_delete AND fk_user = :session_id";

$stmt = $conn -> prepare($query);

$stmt -> bindValue(':id_delete', $product_id, PDO::PARAM_STR);
$stmt -> bindValue(':session_id', $_SESSION['idUser'], PDO::PARAM_INT);

$stmt -> execute();

if($stmt) {
    header("Location: ../public/views/user.php?page=adresses&notice=sucess");
    exit();
} else {
    header("Location: ../public/views/user.php?page=adresses&notice=updatefailed");
    exit();
}