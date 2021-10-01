<?php

    session_start();

    if (!isset($_SESSION['isAuth']) || $_SESSION['idUser'] != -1) {
        header("Location: ../login.php");
        exit();
    }

    $page_title = 'Home - Admin';
    $icon_folder = '../../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../../css/style.css">',
                    '<link rel="stylesheet" href="../../css/admin.css">'];

    require("../../includes/head.php");
    require("../../../app/db/connect.php");

    $query = 'SELECT COUNT(id_user) AS users, (SELECT COUNT(*) FROM products) AS products, 
            (SELECT COUNT(id_order) FROM orders) AS sells
            FROM users';
    $stmt = $conn -> query($query);
    $stmt -> execute();
    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

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

            <?php
                if (isset($_GET['notice'])) {
                    echo 'Cadastro de produto feito com sucesso';
                }
            ?>
            <div class="box">
                <div class="left">
                    Resumo:<br>
                    <?=$return['users']?> usuários cadastrados<br>
                    <?=$return['products']?> produtos cadastrados<br>
                    <?=$return['sells']?> vendas feitas<br>
                </div>
                <div class="right">
                    Páginas de usuário:<br>
                    <a href="../products.php">- Página de produtos</a><br>
                    <a href="../../../index.php">- Página Home</a><br>
                </div>
            </div>
            

            

            

            <a class="btn logout" href="../../../app/logout.php">Logout</a>
        </section>

    </div>
</body>
</html>