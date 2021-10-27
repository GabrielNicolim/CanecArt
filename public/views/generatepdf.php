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
    <table>
        <tr>
            <th>Company</th>
            <th>Contact</th>
            <th>Country</th>
        </tr>
        <tr>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td>Germany</td>
        </tr>
        <tr>
            <td>Centro comercial Moctezuma</td>
            <td>Francisco Chang</td>
            <td>Mexico</td>
        </tr>
    </table>
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

    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }
        
        table {
            border: 1px solid black; 
            width: 100vw;
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 10px;   
        }
    </style>
</head>
<body>

    <h1>'.$titulo.'</h1>
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