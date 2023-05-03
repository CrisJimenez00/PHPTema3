<?php
require "bd_config.php";

function login($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select * from usuarios where usuario=? and clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);

            if($sentencia->rowCount()>0)
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            else
                $respuesta["mensaje"]="Usuario no registrado en BD";

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}
function obtener_usuarios(){
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select * from usuarios";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute();

                $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
           
            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}

?>
