<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SESSION['idUser'] > 0 || $_SERVER['REQUEST_METHOD'] != 'GET') {
    header("Location: ../public/views/products.php");
    exit;
}

require('db/connect.php');
require('functions.php');

$product_id = sanitizeString($_GET['delete']);
$status = (bool)sanitizeString($_GET['status']);
//var_dump($status); exit;
if (empty($product_id) || !is_numeric($product_id) || !is_bool($status)) {
    header("Location: ../public/views/admin/products-admin.php?notice=error");
    exit;
}

// status 0 = restore || status 1 = delete
$status = $status ? 'TRUE' : 'FALSE';

$query = "UPDATE products SET deleted = :status WHERE id_product = :id_product";

$stmt = $conn -> prepare($query);

$stmt -> bindValue(':status', $status, PDO::PARAM_STR);
$stmt -> bindValue(':id_product', $product_id, PDO::PARAM_INT);

$stmt -> execute();

if($stmt) {
    header("Location: ../public/views/admin/products-admin.php?notice=sucess");
    exit();
} else {
    header("Location: ../public/views/admin/products-admin.php?notice=updatefailed");
    exit();
}