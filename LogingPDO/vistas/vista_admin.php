<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login PDO</title>
</head>

<body>
    <div>
        Bienvenido <strong>
            <?php
            echo $datos_usuario_log["usuario"];

            ?>
        </strong>-
        <form action="index.php" class="en_linea" method="post">
            <button type="submit" name="btnSalir">Salir</button>
        </form>
        <?php
        try {

            $consulta = "select * from usuarios where usuario=? and clave=?";
            $sentencia = $conexion->prepare($consulta);

            $respuesta = $sentencia->execute([$_SESION["usuario"], $_SESION["clave"]]); //Si lo pones de forma separada no funciona, porque tiene md5
            $sentencia = null;
            echo "<h3>Listado de los usuarios(no admin)</h3>";
            echo "<table>";
            echo "<tr><th>Nombre</th><th>Usuario</th></tr>";
            foreach ($respuesta as $tupla) {
                echo "<tr><td>" . $tupla["nombre"] . "</td><td>" . $tupla["usuario"] . "</td></tr>";
            }
            echo "</table>";
        } catch (PDOException $e) {
            session_destroy();
            //Así se cierra consulta
            $sentencia = null; //Libera consulta
            $conexion = null; //Cierra la conexión
        
            die(error_page("Loging con PDO", "Login con PDO", "<p>Imposible conectar.Error:" . $e->getMessage() . "</p></body></html>"));
        }

        ?>
    </div>
</body>

</html>