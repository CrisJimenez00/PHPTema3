<?php

session_name("Login_PDO_22_23");
session_start();
require "src/config_bd.php";

//metodo el cual cuando hay un error en la conexión aparece
function error_page($title, $encabezado, $mensaje)
{
    return '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    
    <body>
        <h1>' . $encabezado . '</h1>
    ' . $mensaje . '
    </body>
    
    </html>';
}
if (isset($_SESION["usuario"]) && isset($_SESION["clave"]) && isset($_SESION["ultimo_acceso"])) {

    require "src/seguridad.php";

    if ($datos_usuario_log["tipo"] == "admin") {
        require "vistas/vista_admin.php";
    } else {
        require "vistas/vista_normal.php";
    }

    $conexion = null;

} else {

    require "vistas/vista_login.php";

}
?>