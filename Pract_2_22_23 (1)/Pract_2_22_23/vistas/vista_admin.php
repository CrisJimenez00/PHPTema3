<?php
if(isset($_POST["btnBorrarNuevo"]))
{
    unset($_POST);
    $_SESSION["btnBorrarNuevo"]=true;
    //header("Location:index.php");
    //exit;
}

if(isset($_POST["btnContBorrarFoto"]))
{
    try
        {
            $consulta="update usuarios set foto='no_imagen.jpg' where id_usuario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$_POST["id_usuario"]]);
            $sentencia=null;

            unlink("Img/".$_POST["foto_bd"]);
            $_SESSION["borrarFoto"]=$_POST["id_usuario"];
            header("Location:index.php");
            exit;
        }
        catch(PDOException $e)
        {
            $sentencia=null;
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible realizar la consulta. Error:".$e->getMessage()));
        }
}

if(isset($_POST["btnContEditar"]))
{
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        
        $error_usuario=repetido_edit($conexion,"usuario",$_POST["usuario"],"id_usuario",$_POST["id_usuario"]);
        if(is_string($error_usuario))
        {
            session_destroy();
            $conexion=null;
            die(error_page("Práctica Rec 2","Práctica Rec 2",$error_usuario));
        }
    }
    $error_nombre=$_POST["nombre"]=="";
    $error_dni=$_POST["dni"]==""||!dni_bien_escrito($_POST["dni"])||!dni_valido($_POST["dni"]);
    if(!$error_dni)
    {
        $error_dni=repetido_edit($conexion,"dni",strtoupper($_POST["dni"]),"id_usuario",$_POST["id_usuario"]);
        if(is_string($error_dni))
        {
            session_destroy();
            $conexion=null;
            die(error_page("Práctica Rec 2","Práctica Rec 2",$error_dni));
        }
    }
    $error_sexo=!isset($_POST["sexo"]);
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) ||$_FILES["foto"]["size"] >500*1024);
    $error_form=$error_usuario||$error_nombre||$error_dni||$error_sexo||$error_foto;
    if(!$error_form)
    {
        try
        {
            $subs=0;
            if(isset($_POST["subcripcion"]))
                $subs=1;

            if($_POST["clave"]=="")
            {
                $datos[]=$_POST["nombre"];
                $datos[]=$_POST["usuario"];
                $datos[]=strtoupper($_POST["dni"]);
                $datos[]=$_POST["sexo"];
                $datos[]=$subs;
                $datos[]=$_POST["id_usuario"];
                $consulta="update usuarios set nombre=?, usuario=?, dni=?,sexo=?,subscripcion=? where id_usuario=?";
            }
            else
            {
                $datos[]=$_POST["nombre"];
                $datos[]=$_POST["usuario"];
                $datos[]=md5($_POST["clave"]);
                $datos[]=strtoupper($_POST["dni"]);
                $datos[]=$_POST["sexo"];
                $datos[]=$subs;
                $datos[]=$_POST["id_usuario"];
                $consulta="update usuarios set nombre=?, usuario=?,clave=?,dni=?,sexo=?,subscripcion=? where id_usuario=?";
            }
            $sentencia=$conexion->prepare($consulta);
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

        $mensaje="El usuario ha sido editado con éxito";

        if($_FILES["foto"]["name"]!="")
        {
            $array_ext=explode(".", $_FILES["foto"]["name"]);
            $ext="";
            if(count($array_ext)>0)
                $ext=".".end($array_ext);

            $nombre_nuevo_img="img_".$_POST["id_usuario"].$ext;

            //Siempre se mueve la nueva imagen y después se actualiza o no la base de datos
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nombre_nuevo_img);
            if($var)
            {
                //Si la nueva imagen movida, tiene distinto nombre
                //Hay que actualizar en la BD
                if($nombre_nuevo_img!=$_POST["foto_bd"])
                {
                    try
                    {
                        $consulta="update usuarios set foto=? where id_usuario=?";
                        $sentencia=$conexion->prepare($consulta);
                        $sentencia->execute([$nombre_nuevo_img,$_POST["id_usuario"]]);
                        $sentencia=null;
                        // Al mover otra foto con nombre distinto hay que borrar la foto
                        // anterior siempre que no sea la imagen por defecto
                        if($_POST["foto_bd"]!="no_imagen.jpg")
                            unlink("Img/".$_POST["foto_bd"]);
                    }
                    catch(PDOException $e)
                    {
                        // Como he movido una imagen nueva y no he podido actualizar en BD
                        // tengo que eliminar la imagen nueva movida.
                        unlink("Img/".$nombre_nuevo_img);
                        $sentencia=null;
                        $conexion=null;
                        session_destroy();
                        die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible realizar la consulta. Error:".$e->getMessage()));
                    }
                }
            }
            else
            {
                $mensaje="El usuario ha sido editado dejando la imagen anterior al no poder mover nueva imagen a carpeta destino en el servidor";
            }  
        }
        $_SESSION["accion"]=$mensaje;
        header("Location: index.php");
        exit;

    }
}

if(isset($_POST["btnContNuevo"]))
{
    //comprobar errores formulario
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        
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

        $mensaje="El usuario ha sido registrado con éxito";
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
                    $mensaje="El usuario ha sido registrado con éxito con la imagen por defecto, por un problema con la BD";
                }
                $sentencia=null;
            }
            else
                $mensaje="El usuario ha sido registrado con la imagen por defecto por no poder mover imagen a carpeta destino en el servidor";
        }

        $_SESSION["accion"]=$mensaje;
        header("Location: index.php");
        exit;
    }
}

if(isset($_POST["btnContBorrar"]))
{
    try
    {
        $consulta="delete from usuarios where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnContBorrar"]]);
        $sentencia=null;
        if($_POST["foto"]!="no_imagen.jpg")
            unlink("Img/".$_POST["foto"]);
        
        $_SESSION["accion"]="El usuario ha sido borrado con éxito";
        $_SESSION["pag"]=1;
        header("Location: index.php");
        exit;
    }
    catch(PDOException $e)
    {
        session_destroy();
        $sentencia=null;
        $conexion=null; 
        die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible realizar la consulta. Error:".$e->getMessage()));
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
    <style>
        .en_linea{display:inline}
        .enlace{background:none;border:none;text-decoration:underline;color:blue;cursor:pointer}
        #tabla_principal, #tabla_principal td, #tabla_principal th{border:1px solid black}
        #tabla_principal{width:90%; border-collapse:collapse;text-align:center;margin:0 auto}
        #tabla_principal th{background-color:#CCC}
        #tabla_principal img{height:75px}
        #bot_pag{display:flex;justify-content:center;margin-top:1em}
        #bot_pag button{margin:0 0.25em;padding:0.25em}
        #form_regs_buscar{width:90%;margin:0.5em auto;display:flex;justify-content:space-between}
        .centrado{text-align:center}
        .mensaje{color:blue;font-size:1.25em}
        #form_editar{display:flex;justify-content:space-between;}
        #form_editar img{width:60%}

    </style>
</head>
<body>
    <h1>Práctica Rec 2</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong> - <form method="post" action="index.php" class="en_linea"><button class="enlace" name="btnSalir">Salir</button></form>
    </div>
    <?php
    if(isset($_POST["btnListar"]))
    {
        try
        {
            $consulta="select * from usuarios where id_usuario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$_POST["btnListar"]]);
            echo "<h2>Detalles del usuario con id: ".$_POST["btnListar"]."</h2>";
            if($sentencia->rowCount()>0)
            {
                $datos_usuario=$sentencia->fetch(PDO::FETCH_ASSOC);
                
                echo "<p><strong>Nombre: </strong>".$datos_usuario["nombre"]."</p>";
                echo "<p>.......................</p>";
            }
            else
            {
                echo "<p>El usuario ya no se encuentra registrado en la BD</p>";
            }
            echo "<form action='index.php' method='post'><button>Volver</button></form>";

            $sentencia=null;
        }
        catch(PDOException $e)
        {
            session_destroy();
            $sentencia=null;
            $conexion=null; 
            die("<p>Imposible realizar la consulta. Error:".$e->getMessage()."</p></body></html>");
        }
    }

    if(isset($_POST["btnNuevo"])|| isset($_SESSION["btnBorrarNuevo"])|| isset($_POST["btnContNuevo"]))
    {
        if(isset($_SESSION["btnBorrarNuevo"]))
            unset($_SESSION["btnBorrarNuevo"]);
    ?>
        <h2>Registro de un nuevo Usuario</h2>
        <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Usuario:</label><br/>
            <input type="text" id="usuario" name="usuario" placeholder="Usuario..." value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
            <?php
            if(isset($_POST["btnContNuevo"])&&$error_usuario)
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
            if(isset($_POST["btnContNuevo"])&&$error_nombre)
            {
                echo "<span class='error'> Campo Vacío </span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label><br/>
            <input type="password" id="clave" name="clave" placeholder="Contraseña..." value=""/>
            <?php
            if(isset($_POST["btnContNuevo"])&&$error_clave)
            {
                echo "<span class='error'> Campo Vacío </span>";
            }
            ?>
        </p>
        <p>
            <label for="dni">DNI:</label><br/>
            <input type="text" id="dni" name="dni" placeholder="DNI: 11223344Z" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>"/>
            <?php
            if(isset($_POST["btnContNuevo"])&&$error_dni)
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
            if(isset($_POST["btnContNuevo"])&&$error_sexo)
                echo "<span class='error'> Debes seleccionar un sexo </span>";
            ?>
            <br/>
            <input type="radio" <?php if(isset($_POST["sexo"])&& $_POST["sexo"]=="hombre") echo "checked";?> name="sexo" id="hombre" value="hombre"/> <label for="hombre">Hombre</label><br/>
            <input type="radio" <?php if(isset($_POST["sexo"])&& $_POST["sexo"]=="mujer") echo "checked";?> name="sexo" id="mujer" value="mujer"/> <label for="mujer">Mujer</label>

        </p>
        <p>
            <label for="foto">Incluir mi foto (Máx 500 KB):</label><input type="file" id="foto" name="foto" accept="image/*"/>
            <?php
            if(isset($_POST["btnContNuevo"])&&$error_foto)
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
            <input type="submit" name="btnContNuevo" value="Guardar Cambios"/> 
            <input type="submit" name="btnBorrarNuevo" value="Borrar los datos introducidos"/>
            <input type="submit" name="btnVolver" value="Volver"/>
        </p>
    </form>
    <?php
    }

    if(isset($_POST["btnBorrar"]))
    {
        echo "<div>";
        echo "<h2>Borrado del usuario con id: ".$_POST["btnBorrar"]."</h2>";
        echo "<form action='index.php' method='post'>";
        echo "<input type='hidden' value='".$_POST["foto"]."' name='foto'/>";
        echo "<p class='centrado'>Se dispone usted a borrar al usuario con id: ".$_POST["btnBorrar"]."<br/>";
        echo "¿Estás seguro?</p>";
        echo "<p class='centrado'><button>Cancelar</button> <button name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Continuar</button>";
        echo "</form>";
        echo "</div>";
    }

    if(isset($_POST["btnEditar"]) ||  isset($_SESSION["borrarFoto"])||  isset($_POST["btnVolverBorrarFoto"])||  isset($_POST["btnContEditar"])|| isset($_POST["btnBorrarFoto"]))
    {
        
        if(isset($_POST["btnEditar"])||isset($_SESSION["borrarFoto"]))
        {
            if(isset($_POST["btnEditar"]))
                $id_usuario=$_POST["btnEditar"];
            else
            {
                $id_usuario=$_SESSION["borrarFoto"];
                unset($_SESSION["borrarFoto"]);
            }
            try
            {
                $consulta="select * from usuarios where id_usuario=?";
                $sentencia=$conexion->prepare($consulta);
                $sentencia->execute([$id_usuario]);
                
                if($sentencia->rowCount()>0)
                {
                    $datos_usuario=$sentencia->fetch(PDO::FETCH_ASSOC);
                    
                    $nombre=$datos_usuario["nombre"];
                    $usuario=$datos_usuario["usuario"];
                    $dni=$datos_usuario["dni"];
                    $foto_bd=$datos_usuario["foto"];
                    $subs=$datos_usuario["subscripcion"];
                    $sexo=$datos_usuario["sexo"];
                }
                else
                {
                    $error_existencia=true;
                }
            
                $sentencia=null;
            }
            catch(PDOException $e)
            {
                session_destroy();
                $sentencia=null;
                $conexion=null; 
                die("<p>Imposible realizar la consulta. Error:".$e->getMessage()."</p></body></html>");
            }
        }
        else
        {
            $id_usuario=$_POST["id_usuario"];
            $subs=0;
            if(isset($_POST["subcripcion"]))
                $subs=1;
         
            $usuario=$_POST["usuario"];
            $nombre=$_POST["nombre"];
            $dni=$_POST["dni"];
            $sexo=$_POST["sexo"];
            $foto_bd=$_POST["foto_bd"];
        }

        echo "<h2>Editando el usuario con id: ".$id_usuario."</h2>";
        if(isset($error_existencia))
        {
            echo "<form action='index.php' method='post'>";
            echo "<p>El usuario ya no se encuentra registrado en la BD</p>";
            echo "<p><button>Volver</button></p>";
            echo "</form>";
        }
        else
        {
        ?>
            <form id="form_editar" action="index.php" method="post" enctype="multipart/form-data">
            <div>    
            <p>
                <label for="usuario">Usuario:</label><br/>
                <input type="text" id="usuario" name="usuario" placeholder="Usuario..." value="<?php echo $usuario;?>"/>
                <?php
                if(isset($_POST["btnContEditar"])&&$error_usuario)
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
                <input type="text" id="nombre" name="nombre" placeholder="Nombre..." value="<?php echo $nombre;?>"/>
                <?php
                if(isset($_POST["btnContEditar"])&&$error_nombre)
                {
                    echo "<span class='error'> Campo Vacío </span>";
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label><br/>
                <input type="password" id="clave" name="clave" placeholder="Contraseña..." value=""/>
                
            </p>
            <p>
                <label for="dni">DNI:</label><br/>
                <input type="text" id="dni" name="dni" placeholder="DNI: 11223344Z" value="<?php echo $dni;?>"/>
                <?php
                if(isset($_POST["btnContEditar"])&&$error_dni)
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
                if(isset($_POST["btnContEditar"])&&$error_sexo)
                    echo "<span class='error'> Debes seleccionar un sexo </span>";
                ?>
                <br/>
                <input type="radio" <?php if($sexo=="hombre") echo "checked";?> name="sexo" id="hombre" value="hombre"/> <label for="hombre">Hombre</label><br/>
                <input type="radio" <?php if($sexo=="mujer") echo "checked";?> name="sexo" id="mujer" value="mujer"/> <label for="mujer">Mujer</label>

            </p>
            <p>
                <label for="foto">Incluir mi foto (Máx 500 KB):</label><input type="file" id="foto" name="foto" accept="image/*"/>
                <?php
                if(isset($_POST["btnContEditar"])&&$error_foto)
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
                <input type="checkbox" <?php if($subs==1) echo "checked";?>  name="subcripcion" id="sub"/> <label for="sub">Subcribirme al boletín de novedades</label>
            
            </p>
            <p>
                <input type="hidden" value="<?php echo $foto_bd;?>" name="foto_bd"/>
                <input type="hidden" value="<?php echo $id_usuario;?>" name="id_usuario"/>
                <input type="submit" name="btnContEditar" value="Guardar Cambios"/> 
                <input type="submit" name="btnVolver" value="Volver"/>
            </p>
            </div>
            <div class='centrado'>
                <img src='Img/<?php echo $foto_bd;?>' alt='Foto perfil' title='Foto perfil'/><br/>
                <?php
                if($foto_bd!="no_imagen.jpg")
                {
              
                    if(isset($_POST["btnBorrarFoto"]))
                    {
                            echo "<p>¿Estás seguro que quieres borrar foto?</p>";
                            echo "<p><button name='btnVolverBorrarFoto'>Volver</button> <button name='btnContBorrarFoto'>Continuar</button></p>";
                    }
                    else
                    {
                        echo "<button name='btnBorrarFoto'>Borrar</button>";
                    }
                }
                ?>
            </div>
        </form>
        <?php
        }
    }

    if(isset($_SESSION["accion"]))
    {
        echo "<p class='mensaje'>".$_SESSION["accion"]."</p>";
        unset($_SESSION["accion"]);
    }    
    ?>
    <h2>Listado de los usuarios no admin</h2>
    <?php
    require "vistas/vista_tabla_principal.php";
    ?>
</body>
</html>