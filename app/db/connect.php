<?php

    require_once("env.php");

    date_default_timezone_set('America/Sao_Paulo');

    try {

        $conn = new PDO( DATABASE_INFO['dsn'],DATABASE_INFO['user'] ,DATABASE_INFO['password'] );
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        echo 'Error: '.$e->getCode().' Message: '.$e->getMessage();
    }