<?php

    session_start();
    require_once("../../../app/db/env.php");

    
    if (!isset($_SESSION['isAuth']) || $_SESSION['idUser'] != -1) {
        header("Location: ../login.php");
        exit();
    }

    $page_title = 'Estatísticas';

    $style_scripts = ['<link rel="stylesheet" href="../../css/statistics.css">',
                    '<link rel="stylesheet" href="../../css/admin.css">',
                    '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>'];

    require("../../includes/head.php");
    require('../../../app/getEcommerceData.php');
?>

    <div class="container">
        <!--Header-->
        <header id="top">
            <div class="content">
                <a href="home-admin.php" class="logo">
                    Administrador
                </a>
        
                <nav>
                    <a href="home-admin.php" class="btn">Home</a>
                    <a href="products-admin.php" class="btn">Produtos</a>
                    <a href="peoples-admin.php" class="btn">Pessoas</a>
                    <a href="statistics.php" class="btn active">Estatísticas</a>
                </nav> 
            </div> 
        </header>
        
        <section id="graph">
            <div id="piechart"></div>

            <h1 id="title-product">Produto mais vendido:<br></h1>
            <h2><?=$data[0]['name_product']?></h2>
            <img src="../../images/<?=$data[0]['photo_product']?>">
        </section>
    </div>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Produtos', '% de vendas'],
            <?php
                // check if $data array is empty
                if(!empty($data)) {
                    foreach($data as $key => $value) {
                        echo "['$value[name_product]', $value[sales] ]";
                        if ($stmt -> rowCount() != $key) echo ',';
                    }
                } 
            ?>
        ]);

        var options = {
          title: 'Produtos mais vendidos'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
</body>
</html>