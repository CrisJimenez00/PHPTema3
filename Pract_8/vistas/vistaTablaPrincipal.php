<?php
try
{
    $consulta="select * from usuarios";
    $resultado=mysqli_query($conexion,$consulta);
    echo "<h3 class='centrar'>Listado de los Usuarios</h3>";
    echo "<table class='txt_centrado centrar'>";
    echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button class='enlace' type='submit' name='btnInsertarUsuario'>Usuario+</button></form></th></tr>";
    while($tupla=mysqli_fetch_assoc($resultado))
    {
        echo "<tr>";
        echo "<td>".$tupla["id_usuario"]."</td>";
        echo "<td><img src='Img/".$tupla["foto"]."' alt='Foto de Perfil' title='Foto de Perfil'/></td>";
        echo "<td><form action='index.php' method='post'><button type='submit' value='".$tupla["id_usuario"]."' name='btnListar' class='enlace'>".$tupla["nombre"]."</button></form></td>";
        echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_foto' value='".$tupla["foto"]."'/><button type='submit' value='".$tupla["id_usuario"]."' name='btnBorrar' class='enlace'>Borrar</button> - <button type='submit' value='".$tupla["id_usuario"]."' name='btnEditar' class='enlace'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($resultado);
}
catch(Exception $e)
{
    $mensaje="<p>Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
    mysqli_close($conexion);
    die($mensaje); 
}
?>