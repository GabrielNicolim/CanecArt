<?php
// requires the autoload, data and reference the Dompdf namespace
require ('../../../vendor/autoload.php');
require ('../../../app/db/connect.php');
require('../../../app/getEcommerceData.php');

use Dompdf\Dompdf;

// set locale to portuguese just to make sure
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

$employe = 2303;
$bills = 495;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$titulo = 'Relatório de vendas';

// Setup the paper size,orientation and other options
$dompdf->setPaper('A4', 'portrait');
$options = $dompdf->getOptions();
$options->setDefaultFont('Arial');
$options->setIsHtml5ParserEnabled(true);
$dompdf->setOptions($options);

$html = '<div class="table">
    <table>
        <tr>
            <th>Produto</th>
            <th>Lucro por unidade (R$)</th>
            <th>Preço final</th>
            <th>Numero de Vendas</th>
        </tr>';
        // Loop through the data and build the table profit_margin
        foreach ($products_data as $row) { 
            $profit = $row['price_product'] - $row['base_cost_product'];
            $html .= '<tr>
                <td>'.$row['name_product'].'</td>
                <td>R$ '.sprintf("%.2f",$profit).'</td>
                <td>R$ '.$row['price_product'].'</td>
                <td>'.$row['sales'].'</td>
            </tr>';
        }
        $html .= '
    </table>
    <h2>Faturamento da loja</h2>
    <table>
        <tr>
            <th>Total produtos:</th>
            <th>Contas mensais fixas:</th>
            <th>Mão de obra:</th>
        </tr>
        <tr>
            <td>R$ '.sprintf("%.2f",$profitData['spent']).'</td>
            <td>R$ '.sprintf("%.2f",$bills).'</td>
            <td>R$ '.sprintf("%.2f",$employe).'</td>
        </tr>
        <tr>
            <td colspan="2">Custos totais funcionamento:</td>
            <td>R$ '.sprintf("%.2f",$profitData['spent']+$employe+$bills).'</td>
        </tr>
        <tr>
            <td colspan="2">Faturamento/Receita:</td>
            <td>R$ '.sprintf("%.2f",$profitData['bills']).'</td>
        </tr>
        <tr>
            <td colspan="2">Lucro Liquido:</td>
            <td>R$ '.sprintf("%.2f",$profitData['bills']-($profitData['spent']+$employe+$bills)).'</td>
        </tr>
    </table>
    <br><br><strong>Resumo: </strong> <br>
    '.$info['users'].' usuários cadastrados | 
    '.$info['products'].' produtos cadastrados | 
    '.$info['sells'].' vendas feitas | 
    '.$info['solds'].' produtos vendidos | 
</div>
';

$documentTemplate = '<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="'.URLROOT.'/public/images/logos/favicon.png" type="image/x-icon">
    <style>'.file_get_contents('../../css/pdfstyle.css').'</style>
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

// Debug
//echo $documentTemplate; exit;

$dompdf->loadHtml($documentTemplate);
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
$dompdf->stream("canecartRelatorio".getdate()['mday'].getdate()['mon'].getdate()['year'].".pdf", array("Attachment" => false));    