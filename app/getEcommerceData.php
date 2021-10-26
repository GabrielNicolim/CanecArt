<?php

require('db/connect.php');

// Select all the orders by the most sold products**
$query = "SELECT * FROM eq3.products";

$stmt = $conn -> prepare($query);

$stmt -> execute();

// fetch data from the database
$data = $stmt -> fetchAll();