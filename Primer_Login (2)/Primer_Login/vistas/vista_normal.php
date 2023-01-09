<?php
if(isset($_POST["btnSalir"]))
{
    session_destroy();
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login</title>
    <style>
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
        .enlinea{display:inline}
    </style>
</head>
<body>
    <h1>Primer Login</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong> - 
        <form class="enlinea" action="index.php" method="post">
            <button class='enlace' name='btnSalir'>Salir</button> 
        </form>
    </div>
</body>
</html>