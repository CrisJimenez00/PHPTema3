<?php
if(isset($_POST["btnLogin"]))
{
    $error_usuario=$_POST["usuario"]=="";
    $error_clave= $_POST["clave"]=="";
    $error_form_login= $error_usuario|| $error_clave;
    if(!$error_form_login)
    {
        try
        {
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");

        }
        catch(Exception $e)
        {
            $mensaje="Imposible conectar con la BD. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error();
            session_destroy();
            die(error_page("Primer Login","Primer Login",$mensaje));
        }

        try
        {
            $consulta="select * from usuarios where usuario='".$_POST["usuario"]."' and clave='".md5($_POST["clave"])."'";
            $resultado=mysqli_query($conexion,$consulta);
            $registrado=mysqli_num_rows($resultado)>0;

            mysqli_free_result($resultado);
            mysqli_close($conexion);
            if($registrado)
            {
                $_SESSION["usuario"]=$_POST["usuario"];
                $_SESSION["clave"]=md5($_POST["clave"]);
                $_SESSION["ultimo_acceso"]=time();
                header("Location:index.php");
                exit;

            }
            else
            {
                $error_usuario=true;
            }

        }
        catch(Exception $e)
        {
            $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Primer Login","Primer Login",$mensaje));
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
    <title>Primer Login</title>
</head>
<body>
    <h1>Primer Login</h1>
    <?php
    if(isset($_SESSION["tiempo"]))
    {
        echo "<p class='mensanje'>".$_SESSION["tiempo"]."</p>";
        unset($_SESSION["tiempo"]);
    }
    if(isset($_SESSION["baneo"]))
    {
        echo "<p class='mensanje'>".$_SESSION["baneo"]."</p>";
        unset($_SESSION["baneo"]);
    }
    ?>  
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
            <?php 
            if(isset($_POST["btnLogin"]) && $error_usuario)
                if($_POST["usuario"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* Usuario no se encuentra registrado en BD *</span>";
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave"/>
            <?php 
            if(isset($_POST["btnLogin"]) && $error_clave)
                echo "<span class='error'>* Campo vacío *</span>";
            ?>
        </p>
        <p>
            <button name="btnLogin">Entrar</button> <button name="btnRegistro">Registrar</button>
        </p>

    </form>
</body>
</html>