<?php

    session_start();

    if (!isset($_SESSION['isAuth']) && is_int($_SESSION['idUser']) ) {
        header("Location: login.php");
        exit();
    }

    $page_title = 'Meu perfil';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>',
                    '<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/adresses.css">',
                    '<link rel="stylesheet" href="../css/user.css">',
                    '<link rel="stylesheet" href="../css/list.css">'];
                    

    require("../includes/head.php");
    require("../../app/db/connect.php");

    $query = "SELECT *, (SELECT COUNT(*) FROM eq3.orders WHERE fk_user = :id_session) FROM eq3.users WHERE id_user = :id_session";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_session', $_SESSION['idUser'], PDO::PARAM_INT);
    $stmt -> execute();

    if ($stmt -> rowCount() > 0) {
        $return = $stmt -> fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: ../../app/logout.php");
        exit();
    }

?>

    <div class="shop-car">
        <a href="cart.php">
            <img src="../icons/shop-car.svg" alt="cart_icon">

            <span>
                <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) echo count($_SESSION['cart']) ?>
            </span>
        </a>
    </div>

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

</body>
</html>