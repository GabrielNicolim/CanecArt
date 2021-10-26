<?php
// requires the autoload, data and reference the Dompdf namespace
require ('../../vendor/autoload.php');
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$titulo = 'Relatório de vendas';
$cssfile = '../css/pdfstyle';
@include($cssfile);

//Setup the paper size and orientation
$options = $dompdf->getOptions();
$options->setDefaultFont('Arial');
$options->setIsHtml5ParserEnabled(true);
$dompdf->setOptions($options);
$dompdf->setPaper('A4', 'portrait');

$html = '
<div class="table">
    <div class="row header">
        <div class="cell titleColor">
            <h1>Relatório de Vendas</h1>
        </div>
        <div class="cell titleColor">
            <h1>Relatório de Vendas</h1>
        </div>
        <div class="cell titleColor">
            <h1>Relatório de Vendas</h1>
        </div>
    </div>
</div>
';

$documentTemplate = '<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="'.$cssfile.'.css" rel="stylesheet" >
    <title>'.$titulo.'</title>
</head>
<body>

    <h1>'.$titulo.'</h1><br><br>
    <div id="wrapper">
        '.$html.'
    </div>

</body>
</html>';

$dompdf->loadHtml($documentTemplate);
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));    