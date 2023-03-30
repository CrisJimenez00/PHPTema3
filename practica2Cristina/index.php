<?php
function bien_escrito_dni($texto)
{
    return strlen($texto) == 9 && is_numeric(substr($texto, 0, 8)) && strtoupper(substr($texto, 8, 1)) >= "A" && strtoupper(substr($texto, 8, 1)) <= "Z";
}

if (isset($_POST["btnGuardar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";
    //Si no le obligamos a subir foto sería $_FILES["foto"]["name"] != "" && $_FILES["foto"]["error"]
    $error_archivo = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);
    $error_dni = $_POST["dni"] == "" || !bien_escrito_dni($_POST["dni"]);
    $error_formulario = $error_usuario || $error_nombre || $error_clave || $error_archivo || $error_dni;
}
if (isset($_POST["btnEnviar"]) || isset($_POST["btnRegistrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_formulario = $error_usuario || $error_clave;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 2 Recu Cristina</title>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <?php

    //SI QUIERE ENTRAR EN SU CUENTA
    if (((isset($_POST["btnEnviar"]) || isset($_POST["btnGuardar"]))) && !$error_formulario) {
        ?>
        <style>
            button {
                all: unset;
                color: blue;
                text-decoration: underline;
            }
        </style>
        <form action="index.php" method="post">
            <p> Bienvenido
                <?php echo $_POST["usuario"] ?> - <button type="submit" name="btnSalir">Salir</button>
            </p>
        </form>
        <?php

        //SI LE DA AL BOTÓN REGISTRAR
    } else if (isset($_POST["btnRegistrar"]) || (isset($_POST["btnGuardar"]) && $error_formulario) || isset($_POST["btnBorrar"])) {
        if (isset($_POST["btnBorrar"])) {
            unset($_POST);
        }
        require "vistas/vista_registro.php";

        //LOGIN NORMAL
    } else {
        require "vistas/vista_login.php";
    }

    ?>
</body>

</html>