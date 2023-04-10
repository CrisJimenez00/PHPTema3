<?php
if(!$error_clave&&!$error_usuario){
    /* try
            {
                $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            }
            catch(PDOException $e)
            {
                session_destroy();
                die(error_page("Video Club","Video Club","Imposible conectar. Error: ".$e->getMessage()));
            }

            $consulta="select tipo from clientes where usuario=? and clave=?";
            $datos[]=$_POST["usuario_log"];
            $datos[]=md5($_POST["clave_log"]);
            try
            {
                $sentencia=$conexion->prepare($consulta);
                $sentencia->execute($datos);
                if($sentencia->rowCount()>0)
                {
                    $tupla=$sentencia->fetch(PDO::FETCH_ASSOC);
                    $sentencia=null;
                    $conexion=null;
                    $_SESSION["usuario"]=$datos[0];
                    $_SESSION["clave"]=$datos[1];
                    $_SESSION["ultimo_acceso"]=time();
                    if($tupla["tipo"]=="normal")
                        header("Location:index.php");
                    else
                        header("Location:admin/gest_clientes.php");
                    exit;
                }
                else
                {
                    $error_usuario=true;
                    $sentencia=null;
                    $conexion=null;
                }    


            }
            catch(PDOException $e)
            {
                $sentencia=null;
                $conexion=null;
                session_destroy();
                die(error_page("Video Club","Video Club","Imposible realizar la consulta. Error: ".$e->getMessage()));
            }
            */

}
?>
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
            echo "*Debes rellenar el usuario*";
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