<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../public/views/products.php");
    exit;
}

$id_adress = $_POST['adress'];

if (empty($id_adress) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
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
    
    $sql = "INSERT INTO orders(status_order,fk_user,fk_adress) VALUES('AGUARDANDO PAGAMENTO', :fk_user, :fk_adress) RETURNING id_order";
    $stmt = $conn -> prepare($sql);
    $stmt -> bindValue(':fk_user', $_SESSION['idUser'], PDO::PARAM_INT);
    $stmt -> bindValue(':fk_adress', $id_adress, PDO::PARAM_STR);
    $stmt -> execute();
    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    foreach($_SESSION['cart'] as $product_id) {
        $fk_order = $return['id_order'];
        //echo $product_id;
        $sql = 'INSERT INTO order_products(fk_order, fk_product) VALUES(:fk_order, :fk_product)';
        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':fk_order', $fk_order, PDO::PARAM_STR);
        $stmt -> bindValue(':fk_product', $product_id, PDO::PARAM_INT);
        $stmt -> execute(); 
    }
    unset($_SESSION['cart']);
    echo "Sucess";

} else {
    exit;
}
