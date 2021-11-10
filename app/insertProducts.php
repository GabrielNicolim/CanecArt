<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SESSION['idUser'] > 0 || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../public/views/products.php");
    exit;
}

require('db/connect.php');
require('functions.php');

$product = ucfirst(sanitizeString($_POST['name_product']));
$description = sanitizeString($_POST['description_product']);
$base_cost = filter_var($_POST['base_cost_product'], FILTER_SANITIZE_STRING);
$profit_margin = sanitizeString($_POST['profit_margin']);
$type = strtolower(sanitizeString($_POST['type_product']));
$code_product = filter_var($_POST['code_product'], FILTER_SANITIZE_STRING);
$quantity = filter_var($_POST['quantity_product'], FILTER_SANITIZE_NUMBER_INT);
$photo = null;

if (empty($product) || strlen($product) > 128 || empty($description) || strlen($description) > 512 || empty($type) || strlen($type) > 128 ||
    strlen($quantity) > 9 || empty($quantity) || empty($base_cost) || strlen($base_cost) > 9 || empty($profit_margin) || strlen($profit_margin) > 9 ||
    strlen($code_product) > 14 || strlen($code_product) < 6) {

    header("Location: ../public/views/admin/insert-products-admin.php?notice=invaliddata");
    exit;
}

$price = ($base_cost + ($base_cost * $profit_margin/100))/0.82;

if (!empty($_FILES['photo_product']['name'])) {

    $allowed_formats = ['png', 'jpeg', 'jpg'];
    $extension = strtolower(pathinfo($_FILES['photo_product']['name'], PATHINFO_EXTENSION));
    
    if ( !in_array( $extension , $allowed_formats ) ) {
        header("Location: ../public/views/admin/insert-products-admin.php?notice=invalidimageformat");
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

$query = 'INSERT INTO eq3.products(code_product, name_product, photo_product, description_product, price_product, 
          type_product, quantity_product, base_cost_product, profit_margin, deleted_at) 
          VALUES(:code_product, :name_product, :photo_product, :description_product, :price_product, :type_product, 
          :quantity_product, :base_cost_product, :profit_margin, null) RETURNING id_product;';

$stmt = $conn -> prepare($query);

$stmt -> bindValue(':code_product', $code_product, PDO::PARAM_STR);
$stmt -> bindValue(':name_product', $product, PDO::PARAM_STR);
$stmt -> bindValue(':photo_product', $photo);
$stmt -> bindValue(':description_product', $description, PDO::PARAM_STR);
$stmt -> bindValue(':price_product', $price);
$stmt -> bindValue(':type_product', $type, PDO::PARAM_STR);
$stmt -> bindValue(':base_cost_product', $base_cost);
$stmt -> bindValue(':profit_margin', $profit_margin);
$stmt -> bindValue(':quantity_product', $quantity, PDO::PARAM_INT);

$stmt -> execute();

if ($stmt) {

    header("Location: ../public/views/admin/products-admin.php?notice=success");
    exit;

}