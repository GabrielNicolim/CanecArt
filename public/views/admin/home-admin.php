<?php

    session_start();
    require("../../../app/db/connect.php");

    if (!isset($_SESSION['isAuth']) || $_SESSION['idUser'] != -1) {
        header("Location: ../login.php");
        exit();
    }

    $page_title = 'Home - Admin';

    $style_scripts = ['<link rel="stylesheet" href="../../css/admin.css">'];

    require("../../includes/head.php");
    
    $query = 'SELECT COUNT(id_user) AS users, (SELECT COUNT(*) FROM eq3.products) AS products, 
            (SELECT COUNT(id_order) FROM eq3.orders) AS sells
            FROM eq3.users';
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
                    <a href="../statistics.php" class="btn">Estatísticas</a>
                </nav> 
            </div> 
        </header>

        <section class="panel">

            <h3>Bem vindo de volta administrador</h3>

            <?php
                if (isset($_GET['notice'])) {
                    if ($_GET['notice'] == 'dbsuccess') {
                        echo '<div class="notice success">
                                <p>Banco de dados resetado com sucesso!</p>
                            </div>';
                    } else if ($_GET['notice'] == 'success') {
                        echo '<div class="notice success">
                                <p>Operação realizada com sucesso!</p>
                            </div>';
                    } else if ($_GET['notice'] == 'error') {
                        echo '<div class="notice error">
                                <p>Ocorreu um erro ao realizar a operação!</p>
                            </div>';
                    }
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
            <form action="../../../app/reset_db.php" method="POST">
                <input type="number" name="reset" value="1" hidden>
                <button type="submit" class="btn reset">Resetar Banco de dados</button>
            </form>
        </section>

    </div>
</body>
</html>