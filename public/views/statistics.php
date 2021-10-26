<?php

    session_start();

    $page_title = 'Estatísticas';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/statistics.css">',
                    '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>'];

    require("../includes/head.php");
    require("../../app/db/env.php");
    require ('../../app/getEcommerceData.php');

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
          ['Bulbassauro', 11],
          ['Attack on titan', 2],
          ['Windows',  2],
          ['Genérica', 2],
          ['Jinxs',    7]
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