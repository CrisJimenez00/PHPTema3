<?php
echo "<h2>Aprobado de un comentario</h2>";
echo "<form action='gest_comentarios.php' method='post'>";
echo "<p>¿Está usted seguro que quieres aprobar el comentario con Id=".$_POST["btnAprobar"]."?</p>";
echo "<p><button>Cancelar</button> <button name='btnContAprobar' value='".$_POST["btnAprobar"]."'>Continuar</button></p>";
echo "</form>";
?>