<?php
function bien_escrito_dni($texto)
{
    return strlen($texto) == 9 && is_numeric(substr($texto, 0, 8)) && strtoupper(substr($texto, 8, 1)) >= "A" && strtoupper(substr($texto, 8, 1)) <= "Z";
}
//Control de errores con boton guardar
if (isset($_POST["btnGuardar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";
    //Si no le obligamos a subir foto sería $_FILES["foto"]["name"] != "" && $_FILES["foto"]["error"]
    $error_archivo = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);
    $error_dni = $_POST["dni"] == "" || !bien_escrito_dni($_POST["dni"]);
    $error_formulario = $error_usuario || $error_nombre || $error_clave || $error_archivo || $error_dni;
}
?>
<html>
<!--Formulario-->
<form action="index.php" method="post" enctype="multipart/form-data">


    <p><!--Usuario-->
        <label for="usuario">Usuario:</label>
        <br />
        <input type="text" name="usuario" id="usuario" placeholder="Usuario..." value="<?php
        if (isset($_POST["usuario"])) {
            echo $_POST["usuario"];
        }
        ?>">
        <?php
        if (isset($_POST["btnGuardar"]) && $error_usuario) {
            echo "*Debes rellenar el usuario*";
        }
        ?>
        <br />
        <!--Nombre-->
        <label for="nombre">Nombre:</label>
        <br />
        <input type="text" name="nombre" id="nombre" placeholder="Nombre..." value=<?php
        if (isset($_POST["nombre"]))
            echo $_POST["nombre"];
        ?>>
        <?php
        if (isset($_POST["btnGuardar"]) && $error_nombre) {
            echo "*Debes rellenar el nombre*";
        }
        ?>
        <br />
        <!--Contraseña-->
        <label for="clave">Contraseña:</label>
        <br />
        <input type="password" name="clave" id="clave" placeholder="Contraseña..." value=<?php
        if (isset($_POST["clave"]))
            echo $_POST["clave"];
        ?>>
        <?php
        if (isset($_POST["btnGuardar"]) && $error_clave) {
            echo "*Debes rellenar la contraseña*";
        }
        ?>
        <br />
        <!--DNI-->
        <label for="dni">DNI:</label>
        <br />
        <input type="text" name="dni" id="dni" placeholder="DNI:11223344Z..." value=<?php
        if (isset($_POST["dni"]) && bien_escrito_dni($_POST["dni"]))
            echo $_POST["dni"];
        ?>>
        <?php
        if (isset($_POST["btnGuardar"]) && $error_dni) {
            if ($_POST["dni"] == "") {
                echo "*Debes rellenar el DNI*";
            } else {
                echo "*Debes rellenar el DNI con 8 dígitos seguidos de una letra*";
            }
        }
        ?>
    </p>
    <!--Sexo-->
    <p><label>Sexo:</label>
        <br />
        <input type="radio" name="sexo" id="hombre" value="hombre" checked><label for="hombre">Hombre:</label>
        <br />
        <input type="radio" name="sexo" id="mujer" value="mujer"><label for="mujer">Mujer:</label>
    </p>
    <!--Foto-->
    <p><label for="foto">Incluir mi foto(Máx. 500KB)</label>
        <input type="file" name="foto" id="foto" accept="image/*">
        <?php
        if (isset($_POST["btnGuardar"]) && $error_archivo) {
            if ($_FILES["foto"]["name"] != "") {
                if ($_FILES["foto"]["error"])
                    echo "<span class='error'>Error en la subida del archivo</span>";
                elseif (!getimagesize($_FILES["foto"]["tmp_name"]))
                    echo "<span class='error'>Error no has seleccionado un archivo imagen</span>";
                else
                    echo "<span class='error'>Error el tamaño de la imagen seleccionada supera los 500KB </span>";
            }
        }
        ?>
    </p>
    <!--Checkbox-->
    <p><input type="checkbox" name="boletin" id="boletin">
        <label for="boletin">Suscribirme al boletín de novedades</label>
    </p>
    <!--Botones-->
    <button type="submit" name="btnGuardar">Guardar Cambios</button>
    <button type="submit" name="btnBorrar">Borrar los datos introducidos</button>
</form>
</html>