<?php
$url=DIR_SERV."/login";
$datos_login["usuario"]=$_SESSION["usuario"];
$datos_login["clave"]=$_SESSION["clave"];
$respuesta=consumir_servicios_REST($url,"POST",$datos_login);
$obj=json_decode($respuesta);
if(!$obj)
{
    session_destroy();
    die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
}
if(isset($obj->error))
{
    session_destroy();
    die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>".$obj->error."</p>"));
}

if(isset($obj->usuario))
{
    if(time()-$_SESSION["ultimo_acceso"]>MINUTOS*60)
    {
        session_unset();
        $_SESSION["seguridad"]="Su tiempo de sesión ha caducado. Vuelva a loguearse o registrarse";
        header("Location:index.php");
        exit;
    }
   
}
else
{
    session_unset();
    $_SESSION["seguridad"]="Zona restringida. Vuelva a loguearse o registrarse";
    header("Location:index.php");
    exit;
}

$_SESSION["ultimo_acceso"]=time();
$datos_usuario_log=$obj->usuario;

?>