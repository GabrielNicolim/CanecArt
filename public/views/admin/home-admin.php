<?php

    session_start();

    $page_title = 'Home - Admin';
    $style_sheets = ['../../css/style.css', 
                     '../../css/admin.css'];
    $icon_folder = '../../images/logos/favicon.png';

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
                    <a href="#person-admin" class="btn">Pessoas</a>
                    <a href="#Estatics-admin" class="btn">Estatísticas</a>
                </nav> 
            </div> 
        </header>
    </div>
</body>
</html>