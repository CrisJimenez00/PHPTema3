<?php
echo "<p class='centrar'>Se dispone usted a borrar al usuario <strong>".$_POST["nombre"]."</strong></p>";
echo "<form class='centrar' method='post' action='index.php'>";
echo "<p><button type='submit'>Volver</button><button type='submit' value='".$_POST["btnBorrar"]."' name='btnContinuarBorrar'>Continuar</button></p>";
echo "</form>";
?>