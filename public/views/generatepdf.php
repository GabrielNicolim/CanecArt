<?php
// requires the autoload, data and reference the Dompdf namespace
require ('../../vendor/autoload.php');
require ('../../app/db/connect.php');

use Dompdf\Dompdf;

// set locale to portuguese
setlocale(LC_ALL, 'ptb');

// select all first 15 products ordered by sales
$query = 'SELECT id_product, name_product, SUM(eq3.order_products.quantity_product) AS sales, photo_product,
            price_product, base_cost_product, profit_margin, type_product
            FROM eq3.orders 
            INNER JOIN eq3.order_products ON fk_order = id_order
            INNER JOIN eq3.products ON id_product = fk_product
            WHERE products.deleted = FALSE GROUP BY products.id_product ORDER BY sales DESC';
$stmt = $conn -> prepare($query);
$result = $stmt->execute();
$products_data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$titulo = 'Relatório de vendas';
$cssfile = 'pdfstyle.css';

//Setup the paper size and orientation
$options = $dompdf->getOptions();
$options->setDefaultFont('Arial');
$options->setIsHtml5ParserEnabled(true);
$dompdf->setOptions($options);
$dompdf->setPaper('A4', 'portrait');

$html = '
<div class="table">
    <table>
        <tr>
            <th>Produto</th>
            <th>Lucro por unidade (R$)</th>
            <th>Preço final</th>
            <th>Numero de Vendas</th>
        </tr>';
        // Loop through the data and build the table profit_margin
        
        foreach ($products_data as $row) { 
            $profit = ($row['price_product']*0.82) - $row['base_cost_product'];
            $html .= '<tr>
                <td>'.$row['name_product'].'</td>
                <td>R$ '.$profit.'</td>
                <td>R$ '.$row['price_product'].'</td>
                <td>'.$row['sales'].'</td>
            </tr>';
        }
        $html .= '
    </table>
</div>
';

$documentTemplate = '<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>'.file_get_contents(URLROOT.'/public/css/'.$cssfile).'</style>
    <title>'.$titulo.'</title>
</head>
<body>
    <span id="header">Dados de: '.sprintf("%02d", getdate()['hours']).':'.sprintf("%02d", getdate()['minutes']).':'.sprintf("%02d", getdate()['seconds']).' - '
    .sprintf("%02d", getdate()['mday']).'/'.sprintf("%02d", getdate()['mon']).'/'.sprintf("%02d", getdate()['year']).'</span>
    <h1>'.$titulo.'</h1>
    <div id="wrapper">
        '.$html.'
    </div>

</body>
</html>';

//echo $documentTemplate; exit;

$dompdf->loadHtml($documentTemplate);
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));    