<?php
if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        //Para conectar con la base de datos
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die(error_page("Loging con PDO", "Login con PDO", "<p>Imposible conectar.Error:" . $e->getMessage() . "</p></body></html>"));
        }

        //Para la consulta
        try {

            $consulta = "select * from usuarios where usuario=? and clave=?";
            $sentencia = $conexion->prepare($consulta);
            $datos[] = $_POST["usuario"];
            $datos[] = md5($_POST["clave"]);
            $sentencia->execute($datos); //Si lo pones de forma separada no funciona, porque tiene md5

            //LISTAR
            if ($sentencia->rowCount() > 0) {
                session_name("Login_PDO_22_23");
                session_start();
                $_SESSION["usuario"] = $datos[0];
                $_SESSION["clave"] = $datos[1];
                $_SESSION["ultimo_acceso"] = time();

                header("Location:index.php");
                exit;
            } else {
                $error_usuario = true;
            }
        } catch (PDOException $e) {

            //Así se cierra consulta
            $sentencia = null; //Libera consulta
            $conexion = null; //Cierra la conexión

            die(error_page("Loging con PDO", "Login con PDO", "<p>Imposible conectar.Error:" . $e->getMessage() . "</p></body></html>"));
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login con PDO</title>
</head>

<body>
    <h1>Login con PDO</h1>
    <?php
    if (isset($_SESION["baneo"])) {
        echo "<p class='mensaje'>" . $_SESION["baneo"] . "</p>";
        unset($_SESION["baneo"]);
    } ?>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="" />
            <?php
            if (isset($_POST["usuario"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>Campo vacío</span>";
                } else {
                    echo "<span class='error'>Usuario/Clave no registrada en la BD</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" />
            <?php
            if (isset($_POST["clave"]) && $error_clave) {
                echo "<span class='error'>Campo vacío</span>";
            }
            ?>
        </p>
        <p>
            <input type="submit" name="btnLogin" value="Login" />
        </p>
    </form>
</body>

</html>