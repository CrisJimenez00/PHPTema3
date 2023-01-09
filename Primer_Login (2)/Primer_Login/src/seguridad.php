<?php
 try
 {
     $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
     mysqli_set_charset($conexion,"utf8");

 }
 catch(Exception $e)
 {
     $mensaje="Imposible conectar con la BD. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error();
     session_destroy();
     die(error_page("Primer Login","Primer Login",$mensaje));
 }

 try
 {
     $consulta="select * from usuarios where usuario='".$_SESSION["usuario"]."' and clave='".$_SESSION["clave"]."'";
     $resultado=mysqli_query($conexion,$consulta);

     
     if(mysqli_num_rows($resultado)>0)
     {
         $datos_usuario_log=mysqli_fetch_assoc($resultado);
         mysqli_free_result($resultado);
     }
     else
     {
         mysqli_free_result($resultado);
         mysqli_close($conexion);
         session_unset();
         $_SESSION["baneo"]="Usted ya no se encuentra registrado en la BD";
         header("Location:index.php");
         exit;
     }
     
 }
 catch(Exception $e)
 {
     $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
     mysqli_close($conexion);
     session_destroy();
     die(error_page("Primer Login","Primer Login",$mensaje));
 }
 
 if(time()-$_SESSION["ultimo_acceso"] > MINUTOS * 60)
 {
         session_unset();
         $_SESSION["tiempo"]="Su tiempo de sesión ha expirado";
         header("Location:index.php");
         exit;
 }

?>