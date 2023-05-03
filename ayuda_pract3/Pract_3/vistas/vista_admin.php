<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 3 - SW</title>
    <style>
        
        .en_linea{display:inline}
        .enlace{background:none;border:none;text-decoration:underline;color:blue;cursor:pointer}
        #tabla_principal, #tabla_principal td, #tabla_principal th{border:1px solid black}
        #tabla_principal{width:90%; border-collapse:collapse;text-align:center;margin:0 auto}
        #tabla_principal th{background-color:#CCC}
        #tabla_principal img{height:75px}
    </style>
</head>

<body>
    <h1>Práctica 3 - SW</h1>
    <div>
        Bienvenido <strong>
            <?php echo $datos_usu_log->usuario; ?>
        </strong> -
        <form class="enlinea" action="index.php" method="post">
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
    <?php
    $url = DIR_SERV . "/obtener_usuarios";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die("<p>Error consumiento el servicio: " . $url . "</p></body></html>");
    }
    if (isset($obj->mensaje_error)) {
        session_destroy();
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    }
    echo "<h2>Listado de los usuarios no admin</h2>";
    echo "<table id='tabla_principal'>";
    echo "<tr>";
    echo "<th>#</th><th>Foto</th><th>Nombre</th>";
    echo "<th><form action='index.php' method='post'><button class='enlace' name='btnNuevo'>Usuario+</button></form></th>";
    echo "</tr>";
    foreach ($obj->usuarios as $tupla) {
        if ($tupla->tipo == "normal") {
            echo "<tr>";
            echo "<td>" . $tupla->id_usuario . "</td>";
            echo "<td><img src='Img/" . $tupla->foto . "' alt='foto' title='foto'/></td>";
            echo "<td>" . $tupla->nombre . "</td>";
            //echo "<td><form action='index.php' method='post'><button class='enlace' value='" . $tupla["id_usuario"] . "' name='btnListar' >" . $tupla["nombre"] . "</button></form></td>";
           // echo "<td><form action='index.php' method='post'><input type='hidden' name='foto' value='" . $tupla["foto"] . "'/><button class='enlace' value='" . $tupla["id_usuario"] . "' name='btnBorrar'>Borrar</button> - <button class='enlace' value='" . $tupla["id_usuario"] . "' name='btnEditar'>Editar</button></form></td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    ?>
</body>

</html>