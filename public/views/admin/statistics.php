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
                <a href="home-admin.php" class="logo">Administrador</a>
                <nav>
                    <a href="home-admin.php" class="btn">Home</a>
                    <a href="products-admin.php" class="btn">Produtos</a>
                    <a href="peoples-admin.php" class="btn">Pessoas</a>
                    <a href="statistics.php" class="btn active">Estatísticas</a>
                </nav> 
            </div> 
        </header>
        
        <section id="graph">
            <div class="google_graphs" id="piechart"></div>
            <div class="google_graphs" id="barchart"></div>

            <h1 id="title-product">Produto mais vendido:<br></h1>
            <h2><?=$products_sold[0]['name_product']?></h2>
            <a href="../product-page.php?id=<?=$products_sold[0]['id_product']?>"><img src="../../images/<?=$products_sold[0]['photo_product']?>"></a><br>
            <a href="../generatepdf.php"><h1>Ver PDF de vendas</h1></a>
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
                if(!empty($products_sold)) {
                    foreach($products_sold as $key => $value) {
                        echo "['$value[name_product]', $value[sales] ]";
                        if ($stmt -> rowCount() != $key) echo ',';
                    }
                } 
            ?>
        ]);

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, {title: 'Produtos mais vendidos'});

        // ======================================================================================

        data = google.visualization.arrayToDataTable([
          ['Lucros', '% de vendas'],
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

        var chart = new google.visualization.ColumnChart(document.getElementById('barchart'));
        chart.draw(data, {title: 'Produtos mais vendidos'});
      }
    </script>
</body>
</html>