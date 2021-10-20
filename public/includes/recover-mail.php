<?php

$mail_body = "
<html lang='pt-br'>
    <head>
    <meta charset='UTF-8'>
        <style>
            body{
                width: 100%;
                font-family: Roboto;
                
            }
            #main{
                width: 50%;
                text-align: center;
                margin: auto;
                background-color: rgb(230, 230, 230);
                min-width: 400px;
            }
            h1{
                color: blue;
            }
            #top{
                background: #144ff0;
                color: white;
            }
            button{
                background-color:black;
                color: white;
                font-size: 1.5em; 
                cursor: pointer;
                padding: 1em;
                outline: none;
                border-radius: .5em;
                border: none;
            }
            .texto{
                text-align: justify; 
                padding: 0 16px; 
                font-size: 1.2em;
            }
        </style>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    </head>
    <body>
    <div id='main'>
    <div id='top'height='70px' width='100%'>
        <h2 style='padding-top: 30px; padding-bottom: 30px;'>CanecArt</h2>
    </div>
    <h1>Recuperação de senha</h1>
        <p class='texto'>
        Olá ".ucfirst($name_user).", nós recebemos uma requisição de recuperação de senha da sua conta no CanecArt de ";
        if ($ipDetails->ip == 'Localhost'){
            $mail_body .= "uma máquina local";
        } else {
            $mail_body .= "uma máquina no ip ".$ipDetails->ip." (Localizado no: ".$ipDetails->country." - ".$ipDetails->region." - ".$ipDetails->city.")";
        }
        $mail_body .= ", se você não fez está requisição de recuperação de senha você pode só ignorar esse email.<br><br>
        Este link de autenticação será válido pela próxima 1 hora após esse email ser enviado.
        Clique no botão abaixo para ser redirecionado para criar sua nova senha ou apenas clique no link abaixo:
        </p><br>
        <a href='".$url."'> <button>Criar nova senha</button> </a>
        <br>
        <br>
        <br>
        <a href='".$url."'> ".$url." </a><br><br>
    </div>
    </body>
</html>
";

$mail_AltBody = "Olá ".ucfirst($name_user).", seu provedor de email desabilitou o HTML nos emails ou você o fez manualmente,
portanto, se você requisitou uma mudança/recuperação de senha da sua conta no CanecArt pelo máquina ";
if ($ipDetails->ip == 'Localhost'){
    $mail_AltBody .= "Localhost ";
} else {
    $mail_AltBody .= "com o IP ".$ipDetails->ip." (Locação: ".$ipDetails->country." - ".$ipDetails->region." - ".$ipDetails->city.")";
}
$mail_AltBody .= "Copie e cole o link abaixo para ser redirecionado para criar sua nova senha,
-- Esse link de mudança de senha será válido pela próxima 1 hora após esse email ser enviado: ".$url;