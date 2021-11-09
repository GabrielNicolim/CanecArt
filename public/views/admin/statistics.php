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
    require('../../../app/functions.php');
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
            <div class="google_graphs" id="linechart"></div>

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
                // check if $products_sold array is empty
                if(!empty($products_sold)) {
                    foreach($products_sold as $key => $value) {
                        if ($key != 0 && $key != count($products_sold)) echo ',';
                        echo "['$value[name_product]', $value[sales] ]";
                    }
                } 
            ?>
        ]);

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, {title: 'Produtos mais vendidos'});

        // ======================================================================================

        data = google.visualization.arrayToDataTable([
          ['Lucros', 'R$ por unidade'],
            <?php
                // check if $data array is empty
                if(!empty($data)) {
                    foreach($data as $key => $value) {
                        if ($key != 0 && $key != count($data)) echo ',';
                        echo "['$value[name_product]', $value[absolute_profit] ]";
                    }
                } 
            ?>
        ]);

        var chart = new google.visualization.ColumnChart(document.getElementById('barchart'));
        chart.draw(data, {title: 'Lucro absoluto por produtos'});
        
        // ======================================================================================

        data = google.visualization.arrayToDataTable([
          ['', 'Produtos'],
            <?php
                // check if $chartArea array is empty
                if(!empty($chartArea)) {
                    foreach($chartArea as $key => $value) {
                        if ($key != 0 && $key != count($chartArea)) echo ',';
                        echo '[\''.translateDate($value['date_order'])."', $value[sum] ]";
                    }
                } 
            ?>
        ]);

        var chart = new google.visualization.AreaChart(document.getElementById('linechart'));
        chart.draw(data, {title: 'Produtos vendidos por dia no ultimo mês'});
      }
    </script>
</body>
</html>