<?php
if (isset($_POST["btnBorrar"])) {
    unset($_POST);
}
if (isset($_POST["btnGuardar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_checkbox=!isset($_POST["boletin"]);
    $error_form = $error_usuario || $error_nombre || $error_clave;
}
if (isset($_POST["btnGuardar"]) && !$error_form) {

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 1</title>
</head>

<body>
    <h1>Rellena tu CV</h1>

    <!--Formulario-->
    <form action="index.php" method="post">

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
            <!--Conraseña-->
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
            <input type="text" name="dni" id="dni" placeholder="DNI:11223344Z...">
        </p>
        <!--Sexo-->
        <p><label for="sexo">Sexo:</label>
            <br />
            <input type="radio" name="sexo" id="hombre" value="hombre" checked>Hombre
            <br />
            <input type="radio" name="sexo" id="mujer" value="mujer">Mujer
        </p>
        <!--Foto-->
        <p><label for="foto">Incluir mi foto(Máx. 500KB)</label>
            <input type="file" name="foto" id="foto">
        </p>
        <!--Checkbox-->
        <p><input type="checkbox" name="boletin" id="boletin">
            <label for="boletin">Suscribirme al boletín de novedades</label>
        </p>
        <!--Botones-->
        <button type="submit" name="btnGuardar">Guardar Cambios</button>
        <button type="submit" name="btnBorrar">Borrar los datos introducidos</button>
    </form>
    <?php
    if (isset($_POST["btnGuardar"]) && !$error_form) {
        //Mostramos la info
    
    } /*else {
        //Mostramos formulario
        //require "vistas/vista_formulario.php"
    }*/ ?>
</body>

</html>