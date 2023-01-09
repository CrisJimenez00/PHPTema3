<?php
    require "src/bd_config.php";
    require "src/funciones.php";

    //Conecto siempre ya que siempre termino listando los usuarios
    try
    {
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        die(pag_error("Práctica 8","Práctica 8","Imposible conectar. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error())); 
    }


    if(isset($_POST["btnContBorrarFoto"]))
    {
       
        try
        {
            $consulta="update usuarios set foto='no_imagen.jpg' where id_usuario='".$_POST["id_usuario"]."'";
            mysqli_query($conexion,$consulta);
            if(is_file("Img/".$_POST["nombre_foto"]))
                unlink("Img/".$_POST["nombre_foto"]);

        }
        catch(Exception $e)
        {
            $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
            mysqli_close($conexion);
            die(pag_error("Práctica 8","Práctica 8",$mensaje)); 
        }
    }

    if(isset($_POST["btnContEditar"]))
    {
        $error_nombre=$_POST["nombre"]=="";
        $error_usuario=$_POST["usuario"]=="";
        if(!$error_usuario)
        {
            $error_usuario=repetido($conexion, "usuarios","usuario",$_POST["usuario"],"id_usuario",$_POST["id_usuario"]);
        
            if(is_string($error_usuario))
            {
                    mysqli_close($conexion);
                    die(pag_error("Práctica 8","Práctica 8",$error_usuario)); 
            }
        }
        $error_dni=$_POST["dni"]==""||!bien_escrito_dni($_POST["dni"]) || strtoupper(substr($_POST["dni"],8,1))!=LetraNIF(substr($_POST["dni"],0,8));
        if(!$error_dni)
        {
            $error_dni=repetido($conexion, "usuarios","dni",$_POST["dni"],"id_usuario",$_POST["id_usuario"]);
            
            if(is_string($error_dni))
            {
                mysqli_close($conexion);
                die(pag_error("Práctica 8","Práctica 8",$error_dni)); 
            }
        }
        $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"]||!getimagesize($_FILES["foto"]["tmp_name"])||$_FILES["foto"]["size"]>500*1000);


        $errores_form_editar=$error_nombre||$error_usuario ||$error_dni||$error_foto;
        if(!$errores_form_editar)
        {
            
            if($_POST["clave"]=="")
                $consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', dni='".strtoupper($_POST["dni"])."', sexo='".$_POST["sexo"]."' where id_usuario='".$_POST["id_usuario"]."'";
            else
                $consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', clave='".md5($_POST["clave"])."', dni='".strtoupper($_POST["dni"])."', sexo='".$_POST["sexo"]."' where id_usuario='".$_POST["id_usuario"]."'";

            try
            {
                mysqli_query($conexion,$consulta);
                $mensaje_accion="Usuario editado con Éxito";
                if($_FILES["foto"]["name"]!="")
                {
                   
                    $arr_nombre=explode(".",$_FILES["foto"]["name"]);
                    $ext="";
                    if(count($arr_nombre)>1)
                            $ext=".".end($arr_nombre);
                        
                        $nuevo_nombre="img_".$_POST["id_usuario"].$ext;
                        @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nuevo_nombre);
                        if($var)
                        {
                            if($nuevo_nombre!=$_POST["nombre_foto"])    
                            {
                                try
                                {
                                    $consulta="update usuarios set foto='".$nuevo_nombre."' where id_usuario='".$_POST["id_usuario"]."'";
                                    mysqli_query($conexion,$consulta);
                                    if($_POST["nombre_foto"]!="no_imagen.jpg" && is_file("Img/".$_POST["nombre_foto"]))
                                        unlink("Img/".$_POST["nombre_foto"]);

                                }
                                catch(Exception $e)
                                {
                                    $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
                                    mysqli_close($conexion);
                                    die(pag_error("Práctica 8","Práctica 8",$mensaje)); 
                                }
                            }
                        }
                        else
                        {
                            $mensaje_accion="Usuario editado con Éxito sin cambio de foto, por no poder mover foto elegida en el servidor";
                        }
                }

            }
            catch(Exception $e)
            {
                $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
                mysqli_close($conexion);
                die(pag_error("Práctica 8","Práctica 8",$mensaje)); 
            }
        }

    }


    if(isset($_POST["btnContNuevo"]))
    {
        $error_nombre=$_POST["nombre"]=="";
        $error_usuario=$_POST["usuario"]=="";
        if(!$error_usuario)
        {
            $error_usuario=repetido($conexion, "usuarios","usuario",$_POST["usuario"]);
        
            if(is_string($error_usuario))
            {
                    mysqli_close($conexion);
                    die(pag_error("Práctica 8","Práctica 8",$error_usuario)); 
            }
        }
        $error_clave=$_POST["clave"]=="";
        $error_dni=$_POST["dni"]==""||!bien_escrito_dni($_POST["dni"]) || !valido_dni($_POST["dni"]);
        if(!$error_dni)
        {
            $error_dni=repetido($conexion, "usuarios","dni",$_POST["dni"]);
            
            if(is_string($error_dni))
            {
                mysqli_close($conexion);
                die(pag_error("Práctica 8","Práctica 8",$error_dni)); 
            }
        }	
        $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"]||!getimagesize($_FILES["foto"]["tmp_name"])||$_FILES["foto"]["size"]>500*1000);

    

        $error_form_insert= $error_nombre||$error_usuario|| $error_clave ||$error_dni||$error_foto;
        if(!$error_form_insert)
        {
            
            $consulta="insert into usuarios(nombre,usuario,clave,dni,sexo) values('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".strtoupper($_POST["dni"])."','".$_POST["sexo"]."')";
            try
            {
                    mysqli_query($conexion,$consulta);
                    $mensaje_accion="Usuario insertado con Éxito";
                    if($_FILES["foto"]["name"]!="")
                    {
                        $ultimo_id=mysqli_insert_id($conexion);
                        $arr_nombre=explode(".",$_FILES["foto"]["name"]);
                        $ext="";
                        if(count($arr_nombre)>1)
                            $ext=".".end($arr_nombre);
                        
                        $nuevo_nombre="img_".$ultimo_id.$ext;
                        @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nuevo_nombre);
                        if($var)
                        {
                            try
                            {
                                $consulta="update usuarios set foto='".$nuevo_nombre."' where id_usuario='".$ultimo_id."'";
                                mysqli_query($conexion,$consulta);
                            }
                            catch(Exception $e)
                            {
                                $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
                                mysqli_close($conexion);
                                die(pag_error("Práctica 8","Práctica 8",$mensaje)); 
                            }
                        }
                        else
                        {
                            $mensaje_accion="Usuario insertado con Éxito con foto por defecto, por no poder mover foto elegida en el servidor";
                        }

                    }
            }
            catch(Exception $e)
            {
                $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
                mysqli_close($conexion);
                die(pag_error("Práctica 8","Práctica 8",$mensaje)); 
            }


        }
    }

    if(isset($_POST["btnContinuarBorrar"]))
	{
		
		
		$consulta="delete from usuarios where id_usuario='".$_POST["btnContinuarBorrar"]."'";
		try
		{
				mysqli_query($conexion,$consulta);
				$mensaje_accion="Usuario borrado con Éxito";
                if($_POST["nombre_foto"]!="no_imagen.jpg" && is_file("Img/".$_POST["nombre_foto"]))
                    unlink("Img/".$_POST["nombre_foto"]);

		}
		catch(Exception $e)
		{
			$mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
			mysqli_close($conexion);
			die(pag_error("Práctica 8","Práctica 8",$mensaje)); 
		}
	}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 8</title>
    <style>
    table,
    th,
    td {
        border: 1px solid black;
    }

    table {
        border-collapse: collapse
    }

    td img {
        height: 75px
    }

    .txt_centrado {
        text-align: center;
    }

    .centrar {
        width: 80%;
        margin: 1em auto;
    }

    .enlace {
        border: none;
        background: none;
        text-decoration: underline;
        color: blue;
        cursor: pointer
    }

    .img_listar {
        height: 125px;
        float: left;
        border: 1px solid black;
        margin-right: 2em
    }
    .flexible{display:flex;}
    .flexible > * {width:50%;}
    .flexible img{border:1px solid black}
    .columna{flex-direction:column;justify-content:center}

    </style>
</head>

<body>
    <h1 class="txt_centrado">Práctica 8</h1>
    <?php
    

    if(isset($_POST["btnInsertarUsuario"]) || (isset($_POST["btnContNuevo"]) && $error_form_insert))
    {
        require "vistas/vistaNuevoUsuario.php";
    }

    if(isset($_POST["btnEditar"])|| isset($_POST["btnVolverBorrarFoto"])|| isset($_POST["btnContBorrarFoto"])|| isset($_POST["btnBorrarFoto"])|| (isset($_POST["btnContEditar"])&& $errores_form_editar))
    {
        require "vistas/vistaEditar.php";
    }

    if(isset($_POST["btnListar"]))
    {
        require "vistas/vistaListar.php";

    }

    if(isset($_POST["btnBorrar"]))
    {
        require "vistas/vistaConfBorrarUsuario.php";
    }

    require "vistas/vistaTablaPrincipal.php";

    if(isset($mensaje_accion))//vista mensaje acción
        echo "<p class='centrar'>".$mensaje_accion."</p>";

    
    mysqli_close($conexion);

    ?>
</body>

</html>