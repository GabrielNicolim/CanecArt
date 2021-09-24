<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<a href='../public/views/login.php'>Voltar</a>";
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

    if ($email == 'admin@gmail.com') {
        throw new Exception('alreadyregistered');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //https://www.abstractapi.com/email-verification-validation-api
        //https://www.youtube.com/watch?v=JvGFlAK2fg4
        throw new Exception('invalidemail');
    }
    
    if ($password !== $confirmPassword) {
        throw new Exception('differentpasswords');
    }
    
    if (!validateCPF($cpf)) {
        //throw new Exception('invalidCPF');
    }
    
    if (empty($name_user) || empty($cpf) || empty($password) || empty($confirmPassword)) {
        throw new Exception('datamissing');
    }
    
    $query = 'SELECT email_user, cpf_user FROM users WHERE email_user = :email OR cpf_user = :cpf';
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':email', $email, PDO::PARAM_STR);
    $stmt -> bindValue(':cpf', $cpf, PDO::PARAM_STR);
    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);
    
    if ($stmt -> rowCount() > 0) {
        throw new Exception('alreadyregistered');
    }

} catch (Exception $e) {
    if ($e->getMessage() == 'alreadyregistered') {
        if ($return['email_user'] == $email) {
            header("Location: ../public/views/register.php?error=emailregistered" );
            exit;
        }
        if ($return['cpf_user'] == $cpf) {
            header("Location: ../public/views/register.php?error=CPFregistered" );
            exit;
        }
    }

    header("Location: ../public/views/register.php?error=" . $e->getMessage() );
    exit;
}

$confirmPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);

$query = 'INSERT INTO users(name_user, cpf_user, email_user, password_user, deleted_at) 
          VALUES(:name_user, :cpf_user, :email_user, :password_user, null) ON CONFLICT DO NOTHING RETURNING id_user;';

$stmt = $conn -> prepare($query);

$stmt -> execute( array(':name_user' => $name_user,
                        ':cpf_user' => $cpf,
                        ':email_user' => $email,
                        ':password_user' => $confirmPassword) );

if ($stmt) {

    session_regenerate_id();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    $_SESSION['isAuth'] = true;
    $_SESSION['idUser'] = $return['id_user'];

    echo 'Logged in! ID ='.$_SESSION['idUser'].'<br>';
    echo 'Logout: <a href="logout.php">Log out</a>';

    header("Location: ../public/views/user.php");
    exit;

}




    
