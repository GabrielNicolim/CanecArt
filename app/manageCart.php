<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
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

// Update number of product
if (isset($_POST['id_update']) && isset($_POST['quantity'])) {

    $product_id = intval($_POST['id_update']);
    $quantity = intval($_POST['quantity']);

    if (isset($_SESSION['cart'][$product_id]) && $quantity != $_SESSION['cart'][$product_id] && $quantity >= 0) {
        if ($quantity >= 100) {
            $_SESSION['cart'][$product_id] = 100;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    if ($_SESSION['cart'][$product_id] == 0) {
        unset($_SESSION['cart'][$product_id]);
    }

}

// Clean cart 
if (isset($_POST['remove'])) {
    unset($_SESSION['cart'][intval($_POST['remove'])]);
}

// Add product with its quantity and id
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