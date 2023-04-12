<?php
define("MINUTOS", 5);
//Estoy logueado
try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        //Aquí ya usamos sesiones
        $sentencia->execute([$_SESSION["usuario"], $_SESSION["clave"]]);

        if ($sentencia->rowCount() <= 0) {

            session_unset();
            $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la base de datos";
            $sentencia = null;
            header("Location:index.php");
            exit();
        } else {
            $datos_usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
            $sentencia = null;
        }


    } catch (Exception $e) {
        $sentencia = null;
        $conexion = null;
        die("Imposible realizar la consulta. Error: " . $e->getMessage());
    }

} catch (PDOException $e) {
    session_destroy();
    die("Imposible conectar. Error: " . $e->getMessage());
}

if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
    session_unset();
    $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit();

}
$_SESSION["ultima_accion"] = time();
?>