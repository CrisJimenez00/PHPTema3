<?php
function obtener_productos()
{
    //Conectamos a la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //CONECTAMOS AQUÍ!!!!!!!:
        try {
            $consulta = "SELECT * FROM producto";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Ejecutamos la sentencia:
            $sentencia->execute();

            $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}

function obtener_producto($cod)
{
    //Conectamos a la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //CONECTAMOS AQUÍ!!!!!!!:
        try {
            $consulta = "SELECT * FROM producto WHERE cod = ?";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Metemos los datos:
            $datos[] = $cod;

            //Ejecutamos la sentencia:
            $sentencia->execute($datos);

            $respuesta["producto"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}

//CRUD
//Insertar
function insertar_producto($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "insert into producto(cod, nombre, nombre_corto, descripcion, PVP, familia) set(?,?,?,?,?,?)";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["mensaje"] = $datos[0];

        } catch (PDOException $e) {

            $respuesta["mensaje_error"] = "Imposible conectar.Error:" . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar.Error:" . $e->getMessage();
    }

}

//Cambiar
function actualizar_producto($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "update producto set nombre=?,nombre_corto=?,descripcion=?,PVP=?,familia=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["mensaje"] = $datos[5];

        } catch (PDOException $e) {

            $respuesta["mensaje_error"] = "Imposible conectar.Error:" . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar.Error:" . $e->getMessage();
    }

}

//Eliminar
function borrar_producto($cod)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "delete from producto where cod=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$cod]);
            $respuesta["mensaje"] = $cod;

        } catch (PDOException $e) {

            $respuesta["mensaje_error"] = "Imposible conectar.Error:" . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar.Error:" . $e->getMessage();
    }

}
function obtener_familia($cod)
{
    //Conectamos a la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //CONECTAMOS AQUÍ!!!!!!!:
        try {
            $consulta = "SELECT familia FROM producto WHERE cod = ?";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Metemos los datos:
            $datos[] = $cod;

            //Ejecutamos la sentencia:
            $sentencia->execute($datos);

            $respuesta["producto"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}