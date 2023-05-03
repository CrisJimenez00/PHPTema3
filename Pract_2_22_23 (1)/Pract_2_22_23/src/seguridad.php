<?php
define("MINUTOS",15);
try
{
    $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    try
    {
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$_SESSION["usuario"],$_SESSION["clave"]]);

        if($sentencia->rowCount()<=0)
        {
            $sentencia=null;
            $conexion=null;
            session_unset();
            $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }
        $datos_usuario_log=$sentencia->fetch(PDO::FETCH_ASSOC);
        $sentencia=null;
    }
    catch(PDOException $e)
    {
        session_destroy();
        $sentencia=null;
        $conexion=null; 
        die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible realizar la consulta. Error:".$e->getMessage()));
    }
}
catch(PDOException $e)
{
    session_destroy();
    die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible conectar. Error:".$e->getMessage()));
}

// Y ahora hago el control de tiempo
if(time()-$_SESSION["ultima_accion"]>MINUTOS*60)
{
    $conexion=null;
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
}
$_SESSION["ultima_accion"]=time();
?>