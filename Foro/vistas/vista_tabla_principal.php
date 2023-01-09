<?php
$consulta="select * from usuarios";
$resultado=mysqli_query($conexion,$consulta);
echo "<table class='txt_centrado centrar'>";
echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";
while($tupla=mysqli_fetch_assoc($resultado))
{
    echo "<tr>";
    echo "<td><form action='index.php' method='post'><button type='submit' class='enlace' name='btnListar' value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</button></form></td>";
    echo "<td><form action='index.php' method='post'>";
    echo "<input type='hidden' name='nombre' value='".$tupla["nombre"]."'/>";
    echo "<button type='submit' name='btnBorrar' value='".$tupla["id_usuario"]."'><img src='img/borrar.png' alt='Borrar' title='Borrar usuario'/></button></form></td>";
    echo "<td><form action='index.php' method='post'><button type='submit' name='btnEditar' value='".$tupla["id_usuario"]."'><img src='img/editar.png' alt='Editar' title='Editar usuario'/></button></form></td>";
    echo "</tr>";
}
echo "</table>";

mysqli_free_result($resultado);
?>