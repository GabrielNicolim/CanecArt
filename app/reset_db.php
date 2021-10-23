<?php

// Runs the sql file to reset the database

session_start();

if (!isset($_SESSION['isAuth']) || $_SESSION['idUser'] > 0 || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../public/views/products.php");
    exit;
}

require('db/connect.php');

// Turn on PDO support for multiple queries
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
$sql = file_get_contents('db/sql.sql');
$stmt = $conn->prepare($sql);
$stmt->execute();

if ($stmt) {
    header("Location: ../public/views/admin/home-admin.php?notice=dbsuccess");
    exit();
} else {
    header("Location: ../public/views/admin/home-admin.php?notice=error");
    exit();
}