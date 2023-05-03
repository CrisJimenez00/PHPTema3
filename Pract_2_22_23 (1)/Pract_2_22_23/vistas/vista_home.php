<?php
if(isset($_POST["btnLogin"]))
{
    $error_usuario=$_POST["usuario_log"]=="";
    $error_clave=$_POST["clave_log"]=="";
    if(!$error_usuario && !$error_clave)
    {
        try
        {
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            try
            {
                $clave_encr=md5($_POST["clave_log"]);
                $consulta="select * from usuarios where usuario=? and clave=?";
                $sentencia=$conexion->prepare($consulta);
                $sentencia->execute([$_POST["usuario_log"],$clave_encr]);

                if($sentencia->rowCount()>0)
                {
                    $_SESSION["usuario"]=$_POST["usuario_log"];
                    $_SESSION["clave"]=$clave_encr;
                    $_SESSION["ultima_accion"]=time();
                    $sentencia=null;
                    $conexion=null;
                    header("Location: index.php");
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
                session_destroy();
                $sentencia=null;
                $conexion=null; 
                die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible realizar la consulta. Error:".$e->getMessage()));
            }

           
        }
        catch(PDOException $e)
        {
            session_destroy();
            die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible conectar. Error:".$e->getMessage()));
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
    <title>Práctica Rec 2</title>
</head>
<body>


    <h1>Práctica Rec 2</h1>
    
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario_log" id="usuario" value="<?php if(isset($_POST["usuario_log"])) echo $_POST["usuario_log"];?>"/>
            <?php 
            if(isset($_POST["btnLogin"]) && $error_usuario)
                if($_POST["usuario_log"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* Usuario no registrado en la BD *</span>";
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave_log" id="clave"/>
            <?php 
            if(isset($_POST["btnLogin"]) && $error_clave)
                echo "<span class='error'>* Campo vacío *</span>";
            ?>
        </p>
        <p>
            <button name="btnLogin">Entrar</button> <button name="btnRegistro">Registrar</button>
        </p>

    </form>

    <?php
    if(isset($_SESSION["seguridad"]))
    {
        echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }
    ?>
</body>
</html>