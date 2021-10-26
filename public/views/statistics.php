<?php

    session_start();
    require_once("../../app/db/env.php");

    $page_title = 'Estatísticas';

    $style_scripts = ['<link rel="stylesheet" href="../css/statistics.css">',
                    '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>'];

    require("../includes/head.php");
    require('../../app/getEcommerceData.php');

    echo '<pre>';
    //var_dump($data);
    echo '</pre>';

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
            include("../includes/header.php");
        ?>
            <a href="generatepdf.php">pdfteste</a>
        
        <section>
        
            <div id="piechart" style="width: 100%px; height: 700px;"></div>

            <h1>Produto mais vendido:<br></h1>
            <h2><?=$data[0]['name_product']?></h2>
            <img src="../images/<?=$data[0]['photo_product']?>">
        </section>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Produtos', '% de vendas'],
          <?php 
                foreach($data as $key => $value) {
                    echo "['$value[name_product]', $value[sales] ]";
                    if ($stmt -> rowCount() != $key) echo ',';
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