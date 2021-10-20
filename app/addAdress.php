<?php

session_start();

if (!isset($_SESSION['isAuth']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../public/views/products.php");
    exit;
}

require('db/connect.php');
require('functions.php');

$contact_name = sanitizeString($_POST['name']);
$CEP = sanitizeString($_POST['CEP']);
$city = sanitizeString($_POST['city']);
$state = sanitizeString($_POST['state']);
$number = sanitizeString($_POST['number']);
$street = sanitizeString($_POST['street']);
$district = sanitizeString($_POST['district']);
$complement = sanitizeString($_POST['complement']);

if (empty($contact_name) || empty($CEP) || empty($city) || empty($state) || empty($number) || empty($street) ||
    empty($district) || empty($complement)) {
    header("Location: ../public/views/user.php?page=adresses&error=1");
    exit;
}

$query = 'INSERT INTO eq3.adresses(contact_adress, state_adress, city_adress, street_adress, district_adress, cep_adress, number_adress, complement_adress, fk_user) 
          VALUES(:contact, :state, :city, :street, :district, :cep, :number, :complement, :fk_user)';

$stmt = $conn -> prepare($query);

$stmt -> bindValue(':contact', $contact_name, PDO::PARAM_STR);
$stmt -> bindValue(':state', $state, PDO::PARAM_STR);
$stmt -> bindValue(':city', $city, PDO::PARAM_STR);
$stmt -> bindValue(':street', $street, PDO::PARAM_STR);
$stmt -> bindValue(':district', $district, PDO::PARAM_STR);
$stmt -> bindValue(':cep', $CEP, PDO::PARAM_STR);
$stmt -> bindValue(':number', $number, PDO::PARAM_STR);
$stmt -> bindValue(':complement', $complement, PDO::PARAM_STR);
$stmt -> bindValue(':fk_user', $_SESSION['idUser'], PDO::PARAM_INT);

$stmt -> execute();

if ($stmt) {
    header("Location: ../public/views/user.php?page=adresses&error=0");
    exit;
} else {
    header("Location: ../public/views/user.php?page=adresses&error=1");
    exit;
}