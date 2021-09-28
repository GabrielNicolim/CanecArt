<?php

include("app/db/env.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - not found</title>

    <link rel="shortcut icon" href="public/images/logos/favicon.png" type="image/x-icon">

    <style>
        body {
            background-color: #E0E8FF;
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
        }

        h1 {
            font-size: 10em;
            margin-bottom: 64px;
        }

        div {
            background-color: #F5F7FF;
            width: 80%;
            margin: 10em auto;
            border-radius: 1em;
            padding: 32px;
        }

        a {
            text-decoration: none;
            font-size: 1.2em;
            padding: 5px;
            justify-content: center;
            display: flex;
            color: black;
            margin: 1em auto;
        }

        a:hover {
            transition: 200ms;
        }
    </style>
</head>
<body>
    <div>
        <h1>404</h1>
        <h3> 
            <span>Not found</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bug-fill" viewBox="0 0 16 16">
                <path d="M4.978.855a.5.5 0 1 0-.956.29l.41 1.352A4.985 4.985 0 0 0 3 6h10a4.985 4.985 0 0 0-1.432-3.503l.41-1.352a.5.5 0 1 0-.956-.29l-.291.956A4.978 4.978 0 0 0 8 1a4.979 4.979 0 0 0-2.731.811l-.29-.956z"/>
                <path d="M13 6v1H8.5v8.975A5 5 0 0 0 13 11h.5a.5.5 0 0 1 .5.5v.5a.5.5 0 1 0 1 0v-.5a1.5 1.5 0 0 0-1.5-1.5H13V9h1.5a.5.5 0 0 0 0-1H13V7h.5A1.5 1.5 0 0 0 15 5.5V5a.5.5 0 0 0-1 0v.5a.5.5 0 0 1-.5.5H13zm-5.5 9.975V7H3V6h-.5a.5.5 0 0 1-.5-.5V5a.5.5 0 0 0-1 0v.5A1.5 1.5 0 0 0 2.5 7H3v1H1.5a.5.5 0 0 0 0 1H3v1h-.5A1.5 1.5 0 0 0 1 11.5v.5a.5.5 0 1 0 1 0v-.5a.5.5 0 0 1 .5-.5H3a5 5 0 0 0 4.5 4.975z"/>
            </svg>
        </h3>
        <h2>Desculpe mas essa pagina não foi encontrada no nosso servidor!</h2>
        <p><a href="<?=URLROOT?>">Tente voltar para a home</a></p>
    </div>
</body>
</html>