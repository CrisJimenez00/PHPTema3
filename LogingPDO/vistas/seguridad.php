<?php
define("MINUTOS", 5);

//1º miramos excepciones
try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    die(error_page("Loging con PDO", "Login con PDO", "<p>Imposible conectar.Error:" . $e->getMessage() . "</p></body></html>"));
}
//Para la consulta
try {

    $consulta = "select * from usuarios where usuario=? and clave=?";
    $sentencia = $conexion->prepare($consulta);

    $sentencia->execute([$_SESION["usuario"], $_SESION["clave"]]); //Si lo pones de forma separada no funciona, porque tiene md5

    //Control de seguridad
    if ($sentencia->rowCount() <= 0) {
        $datos_usuario_log = $sentencia->fetch(PDO::FETCH_ASSOC); // Este te devuelve una tupla el FETCH_ALL es para cuando quieres todos
        $sentencia = null; //Libera consulta
    } else {
        $sentencia = null; //Libera consulta
        session_unset();
        $_SESION["seguridad"] = "<p>El usuario ha sido baneado</p>";
        header("Location:index.php");
        exit;
    }
} catch (PDOException $e) {

    //Así se cierra consulta
    $sentencia = null; //Libera consulta
    $conexion = null; //Cierra la conexión

    die(error_page("Loging con PDO", "Login con PDO", "<p>Imposible conectar.Error:" . $e->getMessage() . "</p></body></html>"));
}

if ((time() - $_SESION["ultimo_acceso"]) > 60 * MINUTOS) {
    session_unset();
    $_SESION["seguridad"] = "<p>Su tiempo de sesión ha caducado</p>";
    header("Location:index.php");
    exit;
}
$_SESION["ultimo_acceso"] = time();


?>