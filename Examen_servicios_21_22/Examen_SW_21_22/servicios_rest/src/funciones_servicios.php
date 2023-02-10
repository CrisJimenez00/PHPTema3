<?php
require "config_bd.php";




function conexion_pdo()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $respuesta["mensaje"] = "Conexi&oacute;n a la BD realizada con &eacute;xito";

        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}


function conexion_mysqli()
{
    @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    if (!$conexion)
        $respuesta["error"] = "Imposible conectar:" . mysqli_connect_errno() . " : " . mysqli_connect_error();
    else {
        mysqli_set_charset($conexion, "utf8");
        $respuesta["mensaje"] = "Conexi&oacute;n a la BD realizada con &eacute;xito";
        mysqli_close($conexion);
    }
    return $respuesta;
}
function login($datos, $first_time = true)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            //Consultamos y preparamos la sentencia
            $consulta = "select * from usuarios where usuario=? and clave=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            //Si hay datos es que está logueado
            if ($sentencia->rowCount() > 0) {
                //Entonces lo almacenamos
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

                if ($first_time) {
                    session_name("Examen_21_22");
                    session_start();
                    $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
                    $respuesta["api_sesion"] = session_id();

                }

                //Si no está registrado sale este mensaje
            } else {
                $respuesta["mensaje"] = "El usuario no se encuentra registrado en la base de datos";
            }

            //Cerramos sentencia y conexion
            $sentencia = null;
            $conexion = null;

        } catch (PDOException $e) {

            $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        }
        $conexion = null;

    } catch (PDOException $e) {

        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}
?>