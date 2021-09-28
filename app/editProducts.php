<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SESSION['idUser'] > 0 || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../public/views/products.php");
    exit;
}

require('db/connect.php');
require('functions.php');

$product_id = intval(sanitizeString($_POST['id_product']));

if ($_POST['operation'] == 'Atualizar dados') {

    $product = filter_var($_POST['name_product'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description_product'], FILTER_SANITIZE_STRING);
    $price = (float)sanitizeString($_POST['price_product']);
    $type = filter_var($_POST['type_product'], FILTER_SANITIZE_STRING);
    $quantity = intval(filter_var($_POST['quantity_product'], FILTER_SANITIZE_NUMBER_INT));
    $photo_name = filter_var($_POST['photo_name'], FILTER_SANITIZE_STRING) ?? null;

    if (empty($product) || empty($description) || empty($price) || empty($type) || !is_numeric($quantity)
        || $price < 0 || $quantity < 0) {
        header("Location: ../public/views/admin/edit-product.php?product=".$product_id."&notice=invaliddata");
        exit;
    }

    if (!empty($_FILES['photo_product']['name'])) {
        
        $allowed_formats = ['png', 'jpeg', 'jpg'];
        $extension = strtolower(pathinfo($_FILES['photo_product']['name'], PATHINFO_EXTENSION));
        
        if ( !in_array( $extension , $allowed_formats ) ) {
            header("Location: ../public/views/admin/edit-product.php?notice=invalidimageformat");
            exit;
        }
    
        if ( $_FILES['photo_product']['size'] >= 33554432 ) { //32Mb max size
            header("Location: ../public/views/admin/edit-product.php?notice=bigfile");
            exit();
        }
    
        $rename = 'ProductUpload'.date('Ymdhis').$product.".".$extension;
        $folder = str_replace("\\", '/',substr(__DIR__,0,-3))."public/images/";
        echo $photo_name.$rename;
        if (file_exists('../public/images/'.$photo_name)) {
            if(!unlink('../public/images/'.$photo_name)){
                echo "Something went wrong deleting the media";
            }
        }

        $photo_name = $rename;
        
        if (!move_uploaded_file($_FILES['photo_product']['tmp_name'], $folder.$rename)) {
            
            header("Location: ../../../public/views/admin/edit-product.php?notice=badupload");
            exit();

        }
    }

    $query = "UPDATE products 
            SET name_product = :name_product, photo_product = :photo_product, 
            description_product = :description_product, price_product = :price_product, 
            type_product = :type_product, quantity_product = :quantity_product
            WHERE id_product = :id_product";

    $stmt = $conn -> prepare($query);
    
    $stmt -> bindValue(':name_product', $product, PDO::PARAM_STR);
    $stmt -> bindValue(':photo_product', $photo_name, PDO::PARAM_STR);
    $stmt -> bindValue(':description_product', $description, PDO::PARAM_STR);
    $stmt -> bindValue(':price_product', $price);
    $stmt -> bindValue(':type_product', $type, PDO::PARAM_STR);
    $stmt -> bindValue(':quantity_product', $quantity, PDO::PARAM_INT);
    $stmt -> bindValue(':id_product', $product_id, PDO::PARAM_INT);

    $stmt -> execute();

    if($stmt) {
        header("Location: ../public/views/admin/products-admin.php?notice=sucess");
        exit();
    } else {
        header("Location: ../public/views/admin/products-admin.php?notice=updatefailed");
        exit();
    }

}