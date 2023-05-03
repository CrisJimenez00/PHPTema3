<?php
define("MINUTOS", 5);

$url=DIR_SERV."/login";
$datos_env["usuario"]=$_SESSION["usuario"];
$datos_env["clave"]=$_SESSION["clave"];
$respuesta=consumir_servicios_REST($url,"POST",$datos_env);
$obj=json_decode($respuesta);
if(!$obj)
{
    session_destroy();
    die(error_page("Práctica 3 - SW","Práctica 3 - SW","Error consumiendo el servicio: ".$url.$respuesta));
}
if(isset($obj->mensaje_error))
{
    session_destroy();
    die(error_page("Práctica 3 - SW","Práctica 3 - SW",$obj->mensaje_error));
}

if(isset($obj->mensaje))
{
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}
$datos_usu_log=$obj->usuario;

if(time()-$_SESSION["ultima_accion"]>MINUTOS*60)
{
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
}
$_SESSION["ultima_accion"]=time();
?>