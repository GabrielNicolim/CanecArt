<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$page_title?></title>

    <link rel="shortcut icon" href="<?=$icon_folder?>" type="image/x-icon">

    <?php
        foreach ($style_sheets as $files) {
            echo '<link rel="stylesheet" href="'.$files.'">';
        }

        if (isset($javascript)) {
            foreach ($javascript as $files) {
                echo '<script src="'.$files.'"></script>';
            }
        }
    ?>

</head>
<body>
    