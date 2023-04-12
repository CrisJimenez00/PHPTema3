<?php

//Control de errores con btn Enviar o registrar
if (isset($_POST["btnEnviar"]) || isset($_POST["btnRegistrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_formulario = $error_usuario || $error_clave;
    if (!$error_formulario) {
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            try {
                //Hacemos la consulta
                $consulta = "select * from usuarios where usuario=? and clave=?";
                $sentencia = $conexion->prepare($consulta);
                //hay que guardar la clave en una variable así porque si no da errores en el execute
                $clave_encr = md5($_POST["clave"]);
                $sentencia->execute([$_POST["usuario"], $clave_encr]);
                $respuesta["productos"] = $sentencia->fetch(PDO::FETCH_ASSOC);
                if ($sentencia->rowCount() > 0) {
                    $_SESSION["usuario"] = $_POST["usuario"];
                    $_SESSION["clave"] = $_POST["clave"];
                    $_SESSION["ultima_accion"] = time();
                    $sentencia = null;
                    $conexion = null;
                    header("Location:index.php");
                    exit;
                } else {
                    $error_usuario = true;
                    $sentencia = null;
                    $conexion = null;
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
    
    }
}

?>
<h1>Práctica Rec 2</h1>
<form action="index.php" method="post">
    <!--Usuario-->
    <p> <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" value="<?php
        if (isset($_POST["usuario"])) {
            echo $_POST["usuario"];
        }
        ?>">
        <?php
        if (isset($_POST["btnEnviar"]) && $error_usuario) {
            if ($_POST["usuario"] == "") {
                echo "*Debes rellenar el usuario*";
            } else {
                echo "Usuario no registrado en la base de datos";
            }
        }
        ?>
    </p>
    <!--Contraseña-->
    <p> <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave" value=<?php
        if (isset($_POST["clave"]))
            echo $_POST["clave"];
        ?>>
        <?php
        if (isset($_POST["btnEnviar"]) && $error_clave) {
            echo "*Debes rellenar la contraseña*";
        }
        ?>
    </p>

    <p>
        <!--Botones-->
        <button type="submit" name="btnEnviar">Entrar</button>
        <button type="submit" name="btnRegistrar">Registrarse</button>
    </p>
</form>