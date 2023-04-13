<?php
//Esto debe de ir primero siempre
//Le damos nombre
session_name("login");
//La inicializamos
session_start();
require "src/config_bd.php";
require "src/funciones.php";



//Esta es la estructura básica
if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {
    //Por si le da a salir que se destruya la sesión
    if(isset($_POST["btnSalir"])){
        session_destroy();
        header("Location:index.php");
        exit();
    }

    //Ponemos el código de seguridad
    require "src/seguridad.php";

    //Diferenciamos según el tipo de usuario
    if($datos_usuario["tipo"]=="admin")
    {
        //Si es admin el usuario
        require "vistas/vista_admin.php";

    }else{
        //Si es normal el usuario
        require "vistas/vista_normal.php";

    }
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
