<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit('Form not submited.');
}

require('db/connect.php');
require('functions.php');

$name_user = sanitizeString($_POST['name']);
$cpf = sanitizeString($_POST['cpf']);
$email = trim(filter_var($_POST['email']),FILTER_SANITIZE_EMAIL);
$password = sanitizeString($_POST['password']);
$confirmPassword = sanitizeString($_POST['confirm-password']);

try {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //https://www.abstractapi.com/email-verification-validation-api
        //https://www.youtube.com/watch?v=JvGFlAK2fg4
        throw new Exception('Email is invalid!');
    }
    
    if ($password !== $confirmPassword) {
        throw new Exception('Passwords must be the same!');
    }
    
    if (!validateCPF($cpf)) {
        throw new Exception('CPF is invalid!');
    }
    
    if (empty($name_user) || empty($cpf) || empty($password) || empty($confirmPassword)) {
        throw new Exception('Data missing!');
    }

    $query = 'SELECT COUNT(email_user) FROM users WHERE email_user = :email';
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':email', $email);
    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($return['count'] > 0) {
        throw new Exception('Email aready registered!');
    }

} catch (Exception $e) {
    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
}

$confirmPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);

$query = 'INSERT INTO users(name_user, cpf_user, email_user, password_user) 
          VALUES(:name_user, :cpf_user, :email_user, :password_user) RETURNING id_user;';

$stmt = $conn -> prepare($query);

$stmt -> execute( array(':name_user' => $name_user,
                        ':cpf_user' => $cpf,
                        ':email_user' => $email,
                        ':password_user' => $confirmPassword) );

if ($stmt) {

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    $_SESSION['isAuth'] = true;
    $_SESSION['idUser'] = $return['id_user'];

    echo 'Logged in! ID ='.$_SESSION['idUser'].'<br>';
    echo 'Logout: <a href="logout.php">Log out</a>';

}




    
