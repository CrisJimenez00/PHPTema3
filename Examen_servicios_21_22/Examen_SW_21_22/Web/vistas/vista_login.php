<?php
if(isset($_POST["btnLogin"]))
{
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    if(!$error_usuario && !$error_clave)//Si se ha tecleado algo en ambos campos
    {
        $url=DIR_SERV."/login";
        $datos_login["usuario"]=$_POST["usuario"];
        $datos_login["clave"]=md5($_POST["clave"]);
        $respuesta=consumir_servicios_REST($url,"POST",$datos_login);
        $obj=json_decode($respuesta);
        if(!$obj)
        {
            session_destroy();
            die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
        }
        if(isset($obj->error))
        {
            session_destroy();
            die(error_page("Examen4 PHP","<h1>Examen4 PHP</h1><p>".$obj->error."</p>"));
        }
        if(isset($obj->mensaje))
        {
            $error_usuario=true;
        }
        else
        {
            //Comienzo sesiones y salto a index;
            $_SESSION["usuario"]=$datos_login["usuario"];
            $_SESSION["clave"]=$datos_login["clave"];
            $_SESSION["ultimo_acceso"]=time();
            header("Location:index.php");
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 PHP</title>
</head>
<body>
    <h1>Examen4 PHP</h1>
    <?php
    if(isset($_SESSION["seguridad"]))
    {
        echo "<p class='seguridad'>".$_SESSION["seguridad"]."</p>";
        unset($_SESSION["seguridad"]);
    }
    ?>
    <form action="index.php" method="post">
        <div>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
            <?php
            if(isset($_POST["btnLogin"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* ".$obj->mensaje." *</span>";
            }
            ?>
        </div>
        <div>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" value=""/>
            <?php
            if(isset($_POST["btnLogin"])&& $error_clave)
            {
                echo "<span class='error'>* Campo vacío *</span>";
            }
            ?>
        </div>
        <div>
            <button name="btnLogin">Login</button>
        </div>
    </form>
</body>
</html>