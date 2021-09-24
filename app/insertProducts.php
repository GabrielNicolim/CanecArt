<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SESSION['idUser'] > 0 || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../public/view/products.php");
    exit;
}

require('db/connect.php');
require('functions.php');

$product = filter_var($_POST['name_product'], FILTER_SANITIZE_STRING);
$description = filter_var($_POST['description_product'], FILTER_SANITIZE_STRING);
$price = sanitizeString($_POST['price_product']);
$type = strtolower(filter_var($_POST['type_product'], FILTER_SANITIZE_STRING));
$quantity = filter_var($_POST['quantity_product'], FILTER_SANITIZE_NUMBER_INT);
$photo = null;

//var_dump($_FILES,$_POST); exit;
if (empty($product) || empty($description) || empty($price) || empty($type) || empty($quantity)) {
    header("Location: ../public/view/admin/insert-products-admin.php?notice=invaliddata");
    exit;
}

if (!empty($_FILES['photo_product']['name'])) {

    $allowed_formats = ['png', 'jpeg', 'jpg'];
    $extension = strtolower(pathinfo($_FILES['photo_product']['name'], PATHINFO_EXTENSION));
    
    if ( !in_array( $extension , $allowed_formats ) ) {
        header("Location: ../public/view/admin/insert-products-admin.php?notice=invalidimageformat");
        exit;
    }

    if ( $_FILES['photo_product']['size'] >= 33554432 ) { //32Mb max size
        header("Location: ../../../public/views/user.php?user=".$_SESSION['idUser']."&error=bigfile");
        exit();
    }

    $photo = 'ProductUpload'.date('Ymdhis').trim($product).".".$extension;
    $folder = str_replace("\\", '/',substr(__DIR__,0,-3))."public/images/";

    if (!move_uploaded_file($_FILES['photo_product']['tmp_name'], $folder.$photo)) {
        header("Location: ../../../public/views/user.php?user=".$_SESSION['idUser']."&error=badupload");
        exit();
    }

}

$query = 'INSERT INTO products(name_product, photo_product, description_product, price_product, type_product, quantity_product, deleted_at) 
          VALUES(:name_product, :photo_product, :description_product, :price_product, :type_product, :quantity_product, null) RETURNING id_product;';

$stmt = $conn -> prepare($query);

$stmt -> bindValue(':name_product', $product, PDO::PARAM_STR);
$stmt -> bindValue(':photo_product', $photo);
$stmt -> bindValue(':description_product', $description, PDO::PARAM_STR);
$stmt -> bindValue(':price_product', $price);
$stmt -> bindValue(':type_product', $type, PDO::PARAM_STR);
$stmt -> bindValue(':quantity_product', $quantity, PDO::PARAM_INT);

$stmt -> execute();

if ($stmt) {

    header("Location: ../public/views/admin/products-admin.php?notice=success");
    exit;

}