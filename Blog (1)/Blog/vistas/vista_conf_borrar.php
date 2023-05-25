<?php
echo "<h2>Borrado de un comentario</h2>";
echo "<form action='gest_comentarios.php' method='post'>";
echo "<p>¿Está usted seguro que quieres borrar el comentario con Id=".$_POST["btnBorrar"]."?</p>";
echo "<p><button>Cancelar</button> <button name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Continuar</button></p>";
echo "</form>";
?>