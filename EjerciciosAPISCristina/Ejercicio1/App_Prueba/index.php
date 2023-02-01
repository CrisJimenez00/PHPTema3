<?php
function consumir_servicios_rest($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos)) {
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    }
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>

<body>
    <h1>Listado de los productos</h1>
    <?php
    $url = "http://localhost/PHP/Tema5/Ejercicio1/servicios_rest/productos";
    $respuesta = consumir_servicios_rest($url, "GET");

    //a):
    
    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio rest: " . $url . "</p>" . $respuesta . "</body></html>");
    }

    //Si tenemos error:
    if (isset($obj->mensaje_error)) {
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    }

    //Si queremos ver cuántos elementos tenemos:
    echo "<p>Número de productos: " . count($obj->productos) . "</p>";

    //Listamos:
    echo "<table>";
    echo "<tr><th>Nombre</th><th>PVP</th></tr>";
    foreach ($obj->productos as $tupla) {
        echo "<tr><td>" . $tupla->nombre_corto . "</td><td>" . $tupla->PVP . "</td></tr>";
    }
    echo "</table>";

    echo "<hr>";

    //b):
    
    $url = "http://localhost/PHP/Tema5/Ejercicio1/servicios_rest/producto/3DSNG";
    $respuesta = consumir_servicios_rest($url, "GET");

    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio rest: " . $url . "</p>" . $respuesta . "</body></html>");
    }

    if (isset($obj->mensaje_error)) {
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    }

    if (!$obj->producto) {
        echo "<p>El producto solicitado no se encuentra en la base de datos</p>";
    } else {
        echo "<p><strong>Nombre corto: </strong>" . $obj->producto->nombre_corto . "</p>";
    }

    //c):
    
    $url = "http://localhost/PHP/Tema5/Ejercicio1/servicios_rest/producto/insertar";
    $respuesta = consumir_servicios_rest($url, "PUT");

    
    ?>    
</body>

</html>