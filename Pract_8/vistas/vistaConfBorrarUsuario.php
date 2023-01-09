<?php
echo "<div class='centrar'>";
echo "<h2>Borrado del usuario con ID: ".$_POST["btnBorrar"]."</h2>";
echo "<p>¿ Está ústed seguro ?</p>";
echo "<form method='post' action='index.php'>";
echo "<p><input type='hidden' name='nombre_foto' value='".$_POST["nombre_foto"]."'/><button type='submit'>Volver</button> <button type='submit' value='".$_POST["btnBorrar"]."' name='btnContinuarBorrar'>Continuar</button></p>";
echo "</form></div>";
?>