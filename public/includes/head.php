<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$page_title?></title>

    <link rel="shortcut icon" href="<?=URLROOT?>/public/images/logos/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="<?=URLROOT?>/public/css/style.css">
    <?php
        foreach ($style_scripts as $files) {
            echo $files;
        }
    ?>

</head>
<body>
    