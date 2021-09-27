<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<a href='../public/views/login.php'>Voltar</a>";
    exit('Form not submited.');
}

require('db/connect.php');
require('functions.php');

$email = trim(filter_var($_POST['email']),FILTER_SANITIZE_EMAIL);
$password_user = sanitizeString($_POST['password']);

try {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //https://www.abstractapi.com/email-verification-validation-api
        //https://www.youtube.com/watch?v=JvGFlAK2fg4
        throw new Exception('invaliddata!');
    }

    if (empty($email) || empty($password_user)) {
        throw new Exception('missingdata');
    }

} catch (Exception $e) {
    header("Location: ../public/views/login.php?error=" . $e->getMessage() );
    exit;
}

if ($email == 'admin@gmail.com' && $password_user == 'admin') {
    $_SESSION['isAuth'] = true;   
    $_SESSION['idUser'] = -1;

    header("Location: ../public/views/admin/home-admin.php");
    exit();

}

$dbpassword = generateFakePassword();

$query = 'SELECT id_user, email_user, password_user, deleted, deleted_at FROM users WHERE email_user = :email';
$stmt = $conn -> prepare($query);
$stmt -> bindValue(':email', $email, PDO::PARAM_STR);
$stmt -> execute();

$return = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($stmt -> rowCount() > 0) {
    $dbpassword = $return['password_user'];
}

if ( password_verify($password_user, $dbpassword) ) {

    if ($return['deleted']) {
        header("Location: ../public/views/login.php?error=disabled&date=". $return['deleted_at']);
        exit();
    }

    session_regenerate_id(true);

    $_SESSION['isAuth'] = true;   
    $_SESSION['idUser'] = $return['id_user'];

    if (isset($_COOKIE['resumeProduct'])) {
        header("Location: ../product.php?id=".$_COOKIE['resumeProduct']);
        setcookie("resumeProduct", "", -1 , "/");
        exit();
    }

    header("Location: ../public/views/products.php");
    exit();

} else {
    header("Location: ../public/views/login.php?error=invaliddata");
    exit();
}