<?php
echo "<h2 class='centrar'>Listado del Usuario ".$_POST["btnListar"]."</h2>";
$consulta="select * from usuarios where id_usuario='".$_POST["btnListar"]."'";
try{
    $resultado=mysqli_query($conexion,$consulta);
    echo "<div class='centrar'>";
    if(mysqli_num_rows($resultado)>0)
    {
        $datos_usuario=mysqli_fetch_assoc($resultado);
    
        echo "<p><strong>Nombre: </strong>".$datos_usuario["nombre"]."</p>";
        echo "<p><strong>Usuario: </strong>".$datos_usuario["usuario"]."</p>";
        echo "<p><strong>Email: </strong>".$datos_usuario["email"]."</p>";
    }
    else
    {
        echo "<p>El Usuario seleccionado ya no se encuentra registrado en la BD</p>";
    }
    echo "<form method='post' action='index.php'>";
    echo "<p><button type='submit'>Volver</button></p>";
    echo "</form>";
    echo "</div>";
    mysqli_free_result($resultado);
}
catch(Exception $e)
{
    $mensaje="<p>Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
    mysqli_close($conexion);
    die($mensaje); 
}
?>