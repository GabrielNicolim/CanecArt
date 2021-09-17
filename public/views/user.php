<?php

    session_start();

    $page_title = 'Meu perfil';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/user.css">'];

    require("../includes/head.php");

?>

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
                        }
                    } else {
                        include('content/user/user-data.php');
                    }
                    

                ?>

            </div>
        </div>

        <?php
            include("../includes/footer.php");
        ?>
    </div>

    <!-- <a href="../../app/logout.php">Logout</a> -->
</body>
</html>