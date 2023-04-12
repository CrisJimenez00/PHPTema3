<?php
//Tiempo máximo de sesión:
define("MINUTOS", 5);

//Conectamos a la BD con $_SESSION para el baneo:
try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible conectar. Error: " . $e->getMessage()));
}

//Hacemos nuevamente consulta del usuario, esta vez con $_SESSION:
try {
    $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";

    $sentencia = $conexion->prepare($consulta);

    $datos[] = $_SESSION["usuario"];
    $datos[] = $_SESSION["clave"];

    $sentencia->execute($datos);

    //Si tenemos tuplas, almacenamos los datos del usuario en una variable:
    if ($sentencia->rowCount() > 0) {
        $datos_usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
        //Liberamos sentencia:
        $sentencia = null;
    } else {
        //Si no hay tuplas, es que el usuario ha sido eliminado mientras estaba logueado. Hacemos session_unset().
        session_unset();
        $_SESSION["seguridad"] = "El usuario ya no se encuentra registrado en la BD";
        $sentencia = null;
        //Y saltamos a index.php
        header("Location:index.php");
        exit();
    }
} catch (PDOException $e) {
    $sentencia = null;
    $conexion = null;
    die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible conectar. Error: " . $e->getMessage()));
}

//Controlamos el tiempo de sesión:
if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión ha expirado";
    header("Location:index.php");
    exit();
}

//Refrescamos el tiempo de acceso:
$_SESSION["ultimo_acceso"] = time();