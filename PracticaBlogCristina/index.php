<?php
require "src/config_bd.php";
session_name("Blog_Curso22_23");
session_start();
function error_page($title, $encabezado, $mensaje)
{
    return '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    
    <body>
        <h1>' . $encabezado . '</h1>
    ' . $mensaje . '
    </body>
    
    </html>';
}

if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;


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
    if (isset($_SESION["usuario"]) && isset($_SESION["clave"])) {
        require "login_usuario";
    
    } else {
    
        echo "<span class='error'>Usuario/Clave no registrada en la BD</span>";
    
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica Blog</title>
</head>

<body>
    <h1>Blog Personal</h1>
    <form action="index.php" method="post">
        <p><label for="usuario">Nombre usuario:</label>
            <input type="text" name="usuario" id="usuario">
            <?php
            if (isset($_POST["btnEntrar"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>Campo vacío</span>";
                } else {

                }
            }
            ?>
        </p>
        <p><label for="clave">Clave:</label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["btnEntrar"]) && $error_clave) {
                if ($_POST["clave"] == "") {
                    echo "<span class='error'>Campo vacío</span>";
                } else {
                    echo "<span class='error'>Usuario/Clave no registrada en la BD</span>";
                }
            }
            ?>
        </p>
        <button type="submit" name="btnEntrar">Entrar</button>
        <button type="submit" name="btnRegistrarse" formaction="registro_usuario.php">Registrarse</button>
    </form>
</body>

</html>