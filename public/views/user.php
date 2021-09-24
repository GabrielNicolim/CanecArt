<?php

    session_start();

    $page_title = 'Meu perfil';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>',
                    '<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/adresses.css">',
                    '<link rel="stylesheet" href="../css/user.css">',
                    '<link rel="stylesheet" href="../css/list.css">'];
                    

    require("../includes/head.php");
    require("../../app/db/connect.php");

    $query = "SELECT * FROM users WHERE id_user = :id_session";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_session', $_SESSION['idUser'], PDO::PARAM_INT);
    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

?>

    <a href="car.php" class="shop-car">
        <img src="../icons/shop-car.svg" alt="">
    </a>

    <div class="container">
        <?php
            include('../includes/header.php')
        ?>

        <div class="app">

            <?php

                if (isset($_GET['page'])) {
                    switch($_GET['page']) {
                        case 'data':
                            include('content/user/user-data.php');
                            break;
                        case 'orders':
                            include('content/user/user-orders.php');
                            break;
                        case 'config':
                            include('content/user/user-config.php');
                            break;
                        case 'adresses':
                            include('content/user/user-adresses.php');
                            break;
                        default:
                            include('content/user/user-data.php');
                            break;
                    }
                } else {
                    include('content/user/user-data.php');
                }
                

            ?>

        </div>

        <?php
            include("../includes/footer.php");
        ?>
    </div>

    <!-- <a href="../../app/logout.php">Logout</a> -->
</body>
</html>