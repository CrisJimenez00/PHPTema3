<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2 POO</title>
</head>

<body>
    <?php
    require "class_fruta.php";

    //Como en el constructor se pone el método imprimir(que no es usual), el orden sí afecta.
    echo "<h1>Información de la pera</h1>";
    $pera = new Fruta("verde", "mediano");
    ?>
</body>

</html>