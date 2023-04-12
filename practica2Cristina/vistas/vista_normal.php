<?php
if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista normal</title>
</head>

<body>
    <h1>Practica 2 Recu</h1>
    <style>
        button {
            all: unset;
            color: blue;
            text-decoration: underline;
        }
    </style>
    <form action="index.php" method="post">
        <p> Bienvenido 
            <?php echo $datos_usuario["usuario"] ?> - <button type="submit" name="btnSalir">Salir</button>
        </p>
    </form>
</body>

</html>