<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2</title>
    <style>
        .en_linea{display:inline}
        .enlace{background:none;border:none;text-decoration:underline;color:blue;cursor:pointer}
    </style>
</head>
<body>
    <h1>Práctica Rec 2</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log["usuario"];?></strong> - <form method="post" action="index.php" class="en_linea"><button class="enlace" name="btnSalir">Salir</button></form>
    </div>
    <?php
    if(isset($_SESSION["bienvenida"]))
    {
        echo "<p class='mensaje'>".$_SESSION["bienvenida"]."</p>";
        unset($_SESSION["bienvenida"]);
    }
    ?>
</body>
</html>