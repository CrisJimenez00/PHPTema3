<?php
session_name("pract2_rec_22_23");
session_start();

require "src/bd_config.php";
require "src/funciones.php";


if(isset($_SESSION["usuario"]))
{
    if(isset($_POST["btnSalir"]))
    {
        session_destroy();
        header("Location:index.php");
        exit;
    }

    require "src/seguridad.php";

    // Si voy por aquí, he pasado la seguridad (baneo y tiempo) y tengo:
    //  1) conexion BD abierta
    //  2) Los datos del usuario logueado en $datos_usuario_log

    if($datos_usuario_log["tipo"]=="admin")
        require "vistas/vista_admin.php";
    else
        require "vistas/vista_normal.php";
    
    $conexion=null;
}
elseif(isset($_POST["btnRegistro"]) || isset($_POST["btnContRegistro"]) || isset($_POST["btnBorrarRegistro"]) )
    require "vistas/vista_registro.php";
else
    require "vistas/vista_home.php";
?>