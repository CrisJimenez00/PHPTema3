<?php
session_name("examen_sw_21_22");
session_start();
require "src/ctes_funciones.php";

if(isset($_POST["btnCerrarSesion"]))
{
    session_destroy();
    header("Location:index.php");
    exit;
}

if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"]))
{
    //El usuario se ha logueado al menos una vez correctamente
    //Primero compruebo si se ha baneado
    require "src/seguridad.php";

    if($datos_usuario_log->tipo=="admin")
        require "vistas/vista_principal.php";
    else
        require "vistas/vista_normal.php";


}
else
{
    //El usuario no se ha logueado aún
    require "vistas/vista_login.php";
}
