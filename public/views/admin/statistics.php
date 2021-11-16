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

    $employe = 2303;
    $bills = 495;

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

        <div id="info-about-user">
            <strong>Resumo: </strong> <br>
            <?=$info['users']?> usuários cadastrados<br>
            <?=$info['products']?> produtos cadastrados<br>
            <?=$info['sells']?> vendas feitas<br>
            <?=$info['solds']?> produtos vendidos<br>
        </div>
        
        <section id="graph">
            <div class="google_graphs" id="piechart"></div>
            <div class="google_graphs" id="barchart"></div>
            <div class="google_graphs" id="linechart"></div>

            <div class="product_cost_data">
                <div class="left">
                    <h1 id="title-product">Produto mais vendido:<br></h1>
                    <a href="../product-page.php?id=<?=$products_sold[0]['id_product']?>">
                    <h2><?=$products_sold[0]['name_product']?></h2>
                    <img src="../../images/<?=$products_sold[0]['photo_product']?>"></a>
                </div>
                <div class="right">
                    <table>
                        <tr>
                            <th>Total produtos:</th>
                            <th>Contas mensais fixas:</th>
                            <th>Mão de obra:</th>
                        </tr>
                        <tr>
                            <td>R$ <?=sprintf("%.2f",$profitData['spent'])?></td>
                            <td>R$ <?=sprintf("%.2f",$bills)?></td>
                            <td>R$ <?=sprintf("%.2f",$employe)?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Custos totais funcionamento:</td>
                            <td>R$ <?=sprintf("%.2f",$profitData['spent']+$employe+$bills)?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Impostos:</td>
                            <td>R$ <?=sprintf("%.2f",$profitData['bills']*0.18)?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Faturamento/Receita:</td>
                            <td>R$ <?=sprintf("%.2f",$profitData['bills'])?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            <?php 
                                $final = (($profitData['bills'] - ($profitData['spent']+$employe+$bills)) - $profitData['bills']*0.18); 
                                
                                if($final > 0) 
                                    echo "Lucro";
                                else {
                                    echo "Prejuizo";
                                    $final *= -1; 
                                }    
                            ?> 
                            Liquido:</td>
                            <td>R$ <?=sprintf("%.2f",$final)?></td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <a href="generatepdf.php"><h1>Ver PDF de vendas</h1></a>
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
        chart.draw(data, {title: 'Lucro absoluto por produtos (Após custos e impostos)'});
        
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