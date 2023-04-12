<?php
function bien_escrito($texto)
{
    $dni = strtoupper($texto);
    return strlen($dni) == 9 && is_numeric(substr($dni, 0, 8)) && substr($dni, 8, 1) >= "A" && substr($dni, 8, 1) <= "Z";
}

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