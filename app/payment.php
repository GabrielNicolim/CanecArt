<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../public/views/products.php");
    exit;
}

$id_adress = (int)filter_var($_POST['adress'], FILTER_SANITIZE_NUMBER_INT);

if (empty($id_adress) || !is_numeric($id_adress) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    exit;
}

require('db/connect.php');
require('functions.php');

$sql = 'SELECT COUNT(*) FROM adresses WHERE id_adress = :id_adress AND fk_user = :session_user';
$stmt = $conn -> prepare($sql);
$stmt -> bindValue(':id_adress', $id_adress, PDO::PARAM_STR);
$stmt -> bindValue(':session_user', $_SESSION['idUser'], PDO::PARAM_INT);
$stmt -> execute();

if ($stmt -> rowCount() > 0) {
    
    $random_tracker = bin2hex(random_bytes(6));

    $sql = 'INSERT INTO orders(status_order, fk_user, fk_adress, track_order) 
            VALUES(\'AGUARDANDO PAGAMENTO\', :fk_user, :fk_adress, :track_order)';
    $stmt = $conn -> prepare($sql);
    $stmt -> bindValue(':fk_user', $_SESSION['idUser'], PDO::PARAM_INT);
    $stmt -> bindValue(':fk_adress', $id_adress, PDO::PARAM_STR);
    $stmt -> bindValue(':track_order', $random_tracker, PDO::PARAM_STR);
    $stmt -> execute();
    $id_order = $conn -> lastInsertID();

    foreach($_SESSION['cart'] as $product_id=>$quantity) {
        $sql = 'UPDATE products SET quantity_product = quantity_product - :quantity WHERE id_product = :id_product';
        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':id_product', $product_id, PDO::PARAM_INT);
        $stmt -> bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $stmt -> execute(); 

        $sql = 'INSERT INTO order_products(fk_order, fk_product, quantity_product) VALUES(:fk_order, :fk_product, :quantity_product)';
        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':fk_order', $id_order, PDO::PARAM_STR);
        $stmt -> bindValue(':fk_product', $product_id, PDO::PARAM_INT);
        $stmt -> bindValue(':quantity_product', $quantity, PDO::PARAM_INT);
        $stmt -> execute(); 
    }
    unset($_SESSION['cart']);
    echo "Sucess";

} else {
    exit;
}
