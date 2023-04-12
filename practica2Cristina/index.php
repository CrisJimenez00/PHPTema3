<?php
//Esto debe de ir primero siempre
//Le damos nombre
session_name("login");
//La inicializamos
session_start();
require "src/config_bd.php";

//Esta es la estructura básica
if (isset($_SESSION["usuario"])) {
    require "src/seguridad.php";


    if($datos_usuario["tipo"]=="admin")
    {
        require "vistas/vista_admin.php";

    }else{
        require "vistas/vista_no9rmal.php";

    }
    /*?>
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
    <?php*/
    
    //Si le da al boton registrar o guardar cambios o le da al botón borrar
} else if (isset($_POST["btnRegistrar"]) || isset($_POST["btnGuardar"]) || isset($_POST["btnBorrar"])) {
    if (isset($_POST["btnBorrar"])) {
        unset($_POST);
    }
    require "vistas/vista_registro.php";

} else {
    require "vistas/vista_login.php";
}





//Metodo que te dice si está bien escrito el dni
/*function bien_escrito_dni($texto)
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
*/
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
    
    <?php

     if(isset($_SESSION["seguridad"])){
        echo "<p>".$_SESSION["seguridad"]."</p>";
       }
    ?>
</body>

</html>