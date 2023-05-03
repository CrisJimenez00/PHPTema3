<?php


if(isset($_POST["btnBorrarRegistro"]))
{
    unset($_POST);
    //header("Location:index.php");
    //exit;
}

if(isset($_POST["btnContRegistro"]))
{
    //comprobar errores formulario
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        try
        {
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch(PDOException $e)
        {
            session_destroy();
            die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible realizar la conexión. Error:".$e->getMessage()));
        } 

        $error_usuario=repetido_reg($conexion,"usuario",$_POST["usuario"]);
        if(is_string($error_usuario))
        {
            session_destroy();
            $conexion=null;
            die(error_page("Práctica Rec 2","Práctica Rec 2",$error_usuario));
        }
    }
    $error_nombre=$_POST["nombre"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_dni=$_POST["dni"]==""||!dni_bien_escrito($_POST["dni"])||!dni_valido($_POST["dni"]);
    if(!$error_dni)
    {
        if(!isset($conexion))
        {
            try
            {
                $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            }
            catch(PDOException $e)
            {
                session_destroy();
                die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible realizar la conexión. Error:".$e->getMessage()));
            }
        }

        $error_dni=repetido_reg($conexion,"dni",strtoupper($_POST["dni"]));
        if(is_string($error_dni))
        {
            session_destroy();
            $conexion=null;
            die(error_page("Práctica Rec 2","Práctica Rec 2",$error_dni));
        }
    }
    $error_sexo=!isset($_POST["sexo"]);
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) ||$_FILES["foto"]["size"] >500*1024);
    $error_form=$error_usuario||$error_nombre||$error_clave||$error_dni||$error_sexo||$error_foto;

    if(!$error_form)
    {
        try
        {
            $consulta="insert into usuarios(usuario, clave, nombre, dni,sexo, subscripcion) values(?,?,?,?,?,?)";
            $sentencia=$conexion->prepare($consulta);
            $subs=0;
            if(isset($_POST["subcripcion"]))
                $subs=1;
         
            $datos[]=$_POST["usuario"];
            $datos[]=md5($_POST["clave"]);
            $datos[]=$_POST["nombre"];
            $datos[]=strtoupper($_POST["dni"]);
            $datos[]=$_POST["sexo"];
            $datos[]=$subs;
            $sentencia->execute($datos);
            $sentencia=null;
        }
        catch(PDOException $e)
        {
            $sentencia=null;
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible realizar la consulta. Error:".$e->getMessage()));
        }

        $mensaje="Has sido registrado con éxito";
        if($_FILES["foto"]["name"]!="")
        {
            $ultm_id=$conexion->lastInsertId();
            $array_ext=explode(".", $_FILES["foto"]["name"]);
            $ext="";
            if(count($array_ext)>0)
                $ext=".".end($array_ext);

            $nombre_nuevo_img="img_".$ultm_id.$ext;
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nombre_nuevo_img);
            if($var)
            {
                try
                {
                    $consulta="update usuarios set foto=? where id_usuario=?";
                    $sentencia=$conexion->prepare($consulta);
                    $sentencia->execute([$nombre_nuevo_img,$ultm_id]);
                }
                catch(PDOException $e)
                {
                    unlink("Img/".$nombre_nuevo_img);
                    $mensaje="Has sido registrado con éxito con la imagen por defecto, por un problema con la BD";
                }
                $sentencia=null;
            }
            else
                $mensaje="Has sido registrado con la imagen por defecto por no poder mover imagen a carpeta destino en el servidor";
        }

        $_SESSION["usuario"]=$datos[0];
        $_SESSION["clave"]=$datos[1];
        $_SESSION["ultima_accion"]=time();
        $_SESSION["bienvenida"]=$mensaje;
        $conexion=null;
        header("Location: index.php");
        exit;

    }

    if(isset($conexion))
        $conexion=null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
<h1>Práctica Rec 2</h1>
<form action="index.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="usuario">Usuario:</label><br/>
        <input type="text" id="usuario" name="usuario" placeholder="Usuario..." value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
        <?php
        if(isset($_POST["btnContRegistro"])&&$error_usuario)
        {
            if($_POST["usuario"]=="")
                echo "<span class='error'> Campo Vacío </span>";
            else
                echo "<span class='error'> Usuario repetido </span>";
        }
        ?>
    </p>
    <p>
        <label for="nombre">Nombre:</label><br/>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre..." value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/>
        <?php
        if(isset($_POST["btnContRegistro"])&&$error_nombre)
        {
            echo "<span class='error'> Campo Vacío </span>";
        }
        ?>
    </p>
    <p>
        <label for="clave">Contraseña:</label><br/>
        <input type="password" id="clave" name="clave" placeholder="Contraseña..." value=""/>
        <?php
        if(isset($_POST["btnContRegistro"])&&$error_clave)
        {
            echo "<span class='error'> Campo Vacío </span>";
        }
        ?>
    </p>
    <p>
        <label for="dni">DNI:</label><br/>
        <input type="text" id="dni" name="dni" placeholder="DNI: 11223344Z" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>"/>
        <?php
        if(isset($_POST["btnContRegistro"])&&$error_dni)
            if($_POST["dni"]=="")
                echo "<span class='error'> Campo Vacío </span>";
            else if(!dni_bien_escrito($_POST["dni"]))
                echo "<span class='error'> DNI no está bien escrito </span>";
            else if(!dni_valido($_POST["dni"]))
                echo "<span class='error'> DNI no válido </span>";
            else
                echo "<span class='error'> DNI repetido </span>";
        ?>
    </p>
    <p>
        <label>Sexo:</label>
        <?php
        if(isset($_POST["btnContRegistro"])&&$error_sexo)
            echo "<span class='error'> Debes seleccionar un sexo </span>";
        ?>
        <br/>
        <input type="radio" <?php if(isset($_POST["sexo"])&& $_POST["sexo"]=="hombre") echo "checked";?> name="sexo" id="hombre" value="hombre"/> <label for="hombre">Hombre</label><br/>
        <input type="radio" <?php if(isset($_POST["sexo"])&& $_POST["sexo"]=="mujer") echo "checked";?> name="sexo" id="mujer" value="mujer"/> <label for="mujer">Mujer</label>

    </p>
    <p>
        <label for="foto">Incluir mi foto (Máx 500 KB):</label><input type="file" id="foto" name="foto" accept="image/*"/>
        <?php
        if(isset($_POST["btnContRegistro"])&&$error_foto)
        {
            if($_FILES["foto"]["error"])
            {
                echo "<span class='error'> Error en la subida del fichero al servidor </span>";
            }
            elseif(!getimagesize($_FILES["foto"]["tmp_name"]))
            {
                echo "<span class='error'> Error, no has seleccionado un archivo imagen </span>";
            }
            else
                echo "<span class='error'> Error, el tamaño del fichero seleccionado supera los 500KB </span>";
        }
        ?>
    </p>
    <p>
        <input type="checkbox" <?php if(isset($_POST["subcripcion"])) echo "checked";?>  name="subcripcion" id="sub"/> <label for="sub">Subcribirme al boletín de novedades</label>
       
    </p>
    <p>
        <input type="submit" name="btnContRegistro" value="Guardar Cambios"/> 
        <input type="submit" name="btnBorrarRegistro" value="Borrar los datos introducidos"/>
        <input type="submit" name="btnVolver" value="Volver"/>
    </p>
</form>
</body>
</html>