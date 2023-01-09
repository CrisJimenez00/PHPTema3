<?php
//Recojo datos, bien de la BD, bien de los $_POST
if(isset($_POST["btnEditar"]))
{
    $id_usuario=$_POST["btnEditar"];
    $consulta="select * from usuarios where id_usuario='".$id_usuario."'";
    try{
        $resultado=mysqli_query($conexion,$consulta);
    
        if(mysqli_num_rows($resultado)>0)
        {
            $datos_usuario=mysqli_fetch_assoc($resultado);
            $nombre=$datos_usuario["nombre"];
            $usuario=$datos_usuario["usuario"];
            $email=$datos_usuario["email"];
        
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
    $id_usuario=$_POST["btnContinuarEditar"];
    $nombre=$_POST["nombre"];
    $usuario=$_POST["usuario"];
    $email=$_POST["email"];
}

//Muestro las dos posibles vistas de Editar
echo "<h2 class='centrar'>Editando el Usuario ".$id_usuario."</h2>";
if(isset($error_consistencia))
{
    echo "<div class='centrar'><p>".$error_consistencia."</p>";
    echo "<form method='post' action='index.php'>";
    echo "<p><button type='submit'>Volver</button></p>";
    echo "</form></div>";
}
else
{
?>
<form class="centrar" action="index.php" method="post">
    <p>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $nombre;?>" maxlength="30"/>
        <?php
        if(isset($_POST["nombre"]) && $error_nombre)
            echo "<span class='error'> Campo vacío </span>";
        ?>
    </p>
    <p>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" value="<?php echo $usuario;?>" maxlength="20"/>
        <?php
        if(isset($_POST["usuario"]) && $error_usuario)
            if($_POST["usuario"]=="")
                echo "<span class='error'> Campo vacío </span>";
            else
                echo "<span class='error'> Usuario repetido </span>";
        ?>
    </p>
    <p>
        <label for="clave">Contraseña:</label>
        <input type="password" placeholder="Editar contraseña" name="clave" id="clave" value="" maxlength="20"/>
    </p>
    <p>
        <label for="email">E-mail:</label>
        <input type="text" name="email" id="email" value="<?php echo $email;?>" maxlength="50"/>
        <?php
        if(isset($_POST["email"]) && $error_email)
        {
            if($_POST["email"]=="")
                echo "<span class='error'> Campo vacío </span>";
            elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
                echo "<span class='error'> Email sintácticamente incorrecto </span>";
            else
                echo "<span class='error'> Email repetido </span>";
        }
        ?>
    </p>
    <p>
        <button type="submit" name="btnVolver">Volver</button>
        <button type="submit" value="<?php echo $id_usuario;?>" name="btnContinuarEditar">Continuar</button>
    </p>
</form>
<?php
}