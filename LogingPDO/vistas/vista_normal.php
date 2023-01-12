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
    <title>Login PDO</title>
</head>

<body>
    <div>
        Bienvenido <strong>
            <?php
            echo $datos_usuario_log["usuario"];

            ?>
        </strong>-
        <form action="index.php" class="en_linea" method="post">
            <button type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
</body>

</html>