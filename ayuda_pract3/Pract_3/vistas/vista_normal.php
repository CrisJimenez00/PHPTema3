<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 3 - SW</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
    </style>
</head>
<body>
    <h1>Práctica 3 - SW</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log->usuario;?></strong> - 
        <form class="enlinea" action="index.php" method="post"> 
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
</body>
</html>