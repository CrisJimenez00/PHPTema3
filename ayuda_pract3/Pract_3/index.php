<?php
session_name("pract3_sw_22_23");
session_start();

require "src/funciones.php";
//define("DIR_SERV","http://localhost/Proyectos/Curso22_23/Recup/Servicios_Webs/servicios_rest_login");
define("DIR_SERV","http://localhost/Proyectos/ayuda_pract3/Servicios_Webs/servicios_rest_login");

if(isset($_POST["btnSalir"]))
{
    session_destroy();
    header("Location:index.php");
    exit;
}

if(isset($_SESSION["usuario"]))
{

    require "src/seguridad.php";

    //muestro vista oportuna
    
    if($datos_usu_log->tipo=="admin")
        require "vistas/vista_admin.php";
    else
        require "vistas/vista_normal.php";

}
else
    require "vistas/vista_home.php";

            