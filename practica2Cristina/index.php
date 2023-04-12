<?php
//Esto debe de ir primero siempre
//Le damos nombre
session_name("login");
//La inicializamos
session_start();
require "src/config_bd.php";

//Esta es la estructura básica
if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {
    require "src/seguridad.php";


    if($datos_usuario["tipo"]=="admin")
    {
        //Si es admin el usuario
        require "vistas/vista_admin.php";

    }else{
        //Si es normal el usuario
        require "vistas/vista_normal.php";

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
    /*if (isset($_POST["btnBorrar"])) {
        unset($_POST);
    }*/
    require "vistas/vista_registro.php";

} else {
    require "vistas/vista_login.php";
}





//Metodo que te dice si está bien escrito el dni
/*
*/
?>
<!DOCTYPE html>
<html lang="e">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 2 Recu Cristina</title>
</head>

<body>
    
    
</body>

</html>