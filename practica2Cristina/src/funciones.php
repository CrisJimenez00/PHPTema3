<?php

function error_page($titulo, $encabezado, $cuerpo)
{
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?php $titulo ?>
        </title>
    </head>

    <body>
        <h1>
            <?php $encabezado ?>
        </h1>
        <p>
            <?php $cuerpo ?>
        </p>
    </body>

    </html>
    <?php
}
?>