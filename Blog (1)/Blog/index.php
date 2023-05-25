<?php
session_name("exam_blog_22_23");
session_start();

require "src/funciones_ctes.php";


if(isset($_SESSION["usuario"]))
{
    header("Location:principal.php");
    exit();
}
elseif(isset($_POST["btnRegistro"]) || isset($_POST["btnContRegistro"]))
{
    require "vistas/vista_registro.php";
}
else
{
    require "vistas/vista_login.php";
}

?>