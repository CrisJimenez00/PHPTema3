<?php
require "src/bd_config.php";
require "src/funciones.php";
define("MINUTOS",10);

session_name("primer_login_22_33");
session_start();

if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"])&& (isset($_SESSION["ultimo_acceso"])))
{
    
    require "src/seguridad.php";

    $_SESSION["ultimo_acceso"]=time();

    if($datos_usuario_log["tipo"]=="normal")
        require "vistas/vista_normal.php";
    else
        require "vistas/vista_admin.php";

    mysqli_close($conexion);
   
}
elseif(isset($_POST["btnRegistro"])||isset($_POST["btnContinu"]))
{
    require "vistas/vista_registro.php";
    
}
else
{
    require "vistas/vista_login.php";
}