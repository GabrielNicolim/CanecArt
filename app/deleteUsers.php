<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SESSION['idUser'] > 0 || $_SERVER['REQUEST_METHOD'] != 'GET') {
    header("Location: ../public/views/products.php");
    exit;
}

require('db/connect.php');
require('functions.php');

$user_id = sanitizeString($_GET['delete']);
$status = (bool)sanitizeString($_GET['status']);
//var_dump($status); exit;
if (empty($user_id) || !is_numeric($user_id) || !is_bool($status)) {
    header("Location: ../public/views/admin/products-admin.php?notice=error");
    exit;
}

// status 0 = restore || status 1 = delete
$status = $status ? 'TRUE' : 'FALSE';

$query = "UPDATE users SET deleted = :status, deleted_at = DEFAULT WHERE id_user = :id_user";

$stmt = $conn -> prepare($query);

$stmt -> bindValue(':status', $status, PDO::PARAM_STR);
$stmt -> bindValue(':id_user', $user_id, PDO::PARAM_INT);

$stmt -> execute();

if($stmt) {
    header("Location: ../public/views/admin/peoples-admin.php?notice=sucess");
    exit();
} else {
    header("Location: ../public/views/admin/peoples-admin.php?notice=updatefailed");
    exit();
}