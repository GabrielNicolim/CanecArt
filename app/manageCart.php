<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../public/views/products.php");
    exit;
}

require('db/connect.php');

// Add product from product-page
if (isset($_POST['id']) && isset($_POST['add'])) {
    if (!isset($_SESSION['cart'][intval($_POST['id'])])) {
        $_SESSION['cart'][intval($_POST['id'])] = 1;
    } else {
        $_SESSION['cart'][intval($_POST['id'])] += 1;
    }
    exit;
}

if (isset($_POST['id_update']) && isset($_POST['quantity'])) {

    $product_id = intval($_POST['id_update']);
    $quantity = intval($_POST['quantity']);

    

    if (isset($_SESSION['cart'][$product_id]) && $quantity != $_SESSION['cart'][$product_id]) {
        $_SESSION['cart'][$product_id] = $quantity;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    if ($_SESSION['cart'][$product_id] == 0) {
        unset($_SESSION['cart'][$product_id]);
    }

}

if (isset($_POST['remove'])) {
    unset($_SESSION['cart'][intval($_POST['remove'])]);
}

if (isset($_GET['add_product'])) {
    $id_product = intval(sanitizeString($_GET['add_product']));
    if (!empty($id_product)) {
        if (isset($_SESSION['cart'][$id_product])) {
            $_SESSION['cart'][$id_product] += 1;
        } else {
            $_SESSION['cart'][$id_product] = 1;
        }
    }
}