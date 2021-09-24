<?php

    session_start();

    if (!isset($_SESSION['isAuth']) && $_SESSION['idUser'] != -1) {
        header("Location: ../login.php");
        exit();
    }

    $page_title = 'Home - Admin';
    $icon_folder = '../../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../../css/style.css">',
                    '<link rel="stylesheet" href="../../css/admin.css">'];

    require("../../includes/head.php");

?>
    <div class="container">
        <header id="top">
            <div class="content">
                <a href="home-admin.php" class="logo">
                    Administrador
                </a>
        
                <nav>
                    <a href="home-admin.php" class="btn active">Home</a>
                    <a href="products-admin.php" class="btn">Produtos</a>
                    <a href="peoples-admin.php" class="btn">Pessoas</a>
                    <a href="#Estatics-admin" class="btn">Estatísticas</a>
                </nav> 
            </div> 
        </header>

        <section class="panel">

            <h3>Bem vindo de volta administrador</h3>

            <a href="../products.php">Página de produtos</a><br>

            <?php
                if (isset($_GET['notice'])) {
                    echo 'Cadastro de produto feito com sucesso';
                }
            ?>

            <a class="btn logout" href="../../../app/logout.php">Logout</a>
        </section>

    </div>
</body>
</html>