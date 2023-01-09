<?php
if(isset($_POST["btnEditar"])|| isset($_POST["btnContBorrarFoto"])||isset($_POST["btnBorrarFoto"])|| isset($_POST["btnVolverBorrarFoto"]))
{
    if(isset($_POST["btnEditar"]))
        $id_usuario= $_POST["btnEditar"];
    else
        $id_usuario=$_POST["id_usuario"];
    

    $consulta="select * from usuarios where id_usuario='".$id_usuario."'";
    try{
        $resultado=mysqli_query($conexion,$consulta);
        
        if(mysqli_num_rows($resultado)>0)
        {
            $datos_usuario=mysqli_fetch_assoc($resultado);
            $nombre=$datos_usuario["nombre"];
            $usuario=$datos_usuario["usuario"];
            $dni=$datos_usuario["dni"];
            $sexo=$datos_usuario["sexo"];
            $nombre_foto=$datos_usuario["foto"];
            
        }
        else
        {
            $error_consistencia="El Usuario seleccionado ya no se encuentra registrado en la BD";
        }
        
        mysqli_free_result($resultado);
    }
    catch(Exception $e)
    {
        $mensaje="<p>Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
        mysqli_close($conexion);
        die($mensaje); 
    }
}
else
{
    $id_usuario=$_POST["id_usuario"];
    $nombre=$_POST["nombre"];
    $usuario=$_POST["usuario"];
    $dni=$_POST["dni"];
    $sexo=$_POST["sexo"];
    $nombre_foto=$_POST["nombre_foto"];
}

echo "<h2 class='centrar'>Editando al usuario con Id: ".$id_usuario."</h2>";
if(isset($error_consistencia))
{
    echo "<div class='centrar'>";
    echo "<p>".$error_consistencia."</p>";
    echo "<form method='post' action='index.php'>";
    echo "<p><button type='submit'>Volver</button></p>";
    echo "</form>";
    echo "</div>";
}
else
{
?>
    <form class='flexible centrar' method="post" action="index.php" enctype="multipart/form-data">
    <div>
        <p><label for="nombre">Nombre: </label><br />
        <input type="text" name="nombre" id="nombre" placeholder="Nombre..." size="30" value="<?php echo $nombre;?>"/>
        <?php
            if(isset($_POST["btnContEditar"]) && $error_nombre)
                echo "<span class='error'>* Campo vacío *</span>";
        ?>
        </p>
        <p>
        <label for="usuario">Usuario: </label><br />
        <input type="text" name="usuario" id="usuario" placeholder="Usuario..." value="<?php echo $usuario;?>"/>
        <?php
            if(isset($_POST["btnContEditar"]) && $error_usuario)
                if($_POST["usuario"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                else echo "<span class='error'>* Usuario repetido *</span>";
        ?>
        </p>
        <p>
        <label for="clave">Contraseña: </label><br />
        <input type="password" name="clave" id="clave" placeholder="Edite su contraseña..." />
    
        </p>
        <p>
        <label for="dni">DNI: </label><br />
        <input type="dni" name="dni" id="dni" placeholder="DNI: 11223344A" value="<?php echo $dni;?>"/>
        <?php
            if(isset($_POST["btnContEditar"]) && $error_dni)
            {
                if($_POST["dni"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                elseif(!bien_escrito_dni($_POST["dni"]))
                    echo "<span class='error'>* Dni no está bien escrito*</span>";
                elseif(!valido_dni($_POST["dni"]))
                    echo "<span class='error'>* DNI no válido *</span>";
                else
                    echo "<span class='error'>* DNI repetido *</span>";
            }
        ?>
        </p>
        <p>
        <label>Sexo</label><br />
        <input type="radio" name="sexo" value="hombre" id="hombre" <?php if($sexo=="hombre") echo "checked";?>/>
        <label for="hombre">Hombre: </label> <br />

        <input type="radio" name="sexo" value="mujer" id="mujer" <?php if($sexo=="mujer") echo "checked";?>/>
        <label for="mujer">Mujer: </label>

        </p>
        <p>
        <label for="foto">Incluir mi foto (Max. 500KB)</label>
        <input type="file" name="foto" id="foto" accept="image/*"/>			
        <?php
        if(isset($_POST["btnContEditar"])&& $error_foto)
        {
            if($_FILES["foto"]["error"])
                echo "<span class=''>* Error en la subida del fichero *</span>";
            elseif(!getimagesize($_FILES["foto"]["tmp_name"]))
                echo "<span class=''>* El fichero subido no es un archivo imagen *</span>";
            else
                echo "<span class=''>* El tamaño del fichero supera los 500KB *</span>";
        }

        ?>
        </p>
        <p>
        <input type="submit" value="Volver" />
        <input type="hidden" value="<?php echo $id_usuario;?>" name="id_usuario"/>
        <input type="hidden" name="nombre_foto" value="<?php echo $nombre_foto;?>"/>
        <input type="submit" name="btnContEditar" value="Continuar"/>

        </p>
    </div>
    <div class="flexible columna">
        <img src="Img/<?php echo $nombre_foto;?>" alt="Foto de perfil" title="Foto de perfil"/>
        <?php
            if(isset($_POST["btnBorrarFoto"]))
            {
                echo "<p class='txt_centrado'>¿ Estás seguro ?</p>";
                echo "<p class='txt_centrado'><button type='submit' name='btnVolverBorrarFoto'>Volver</button> <button type='submit' name='btnContBorrarFoto'>Continuar</button></p>";
            }
            elseif($nombre_foto!="no_imagen.jpg")
                echo "<p class='txt_centrado'><button type='submit' name='btnBorrarFoto' >Borrar</button></p>";
        ?>
    </div>
    </form>


<?php   
}
?>