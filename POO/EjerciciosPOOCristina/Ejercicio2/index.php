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
    $pera = new Fruta();
    $pera->set_color("verde");
    $pera->set_tamano("mediano");
    echo "<h1>Información de la pera</h1>";
    echo "<p>Color: ".$pera->get_color().", Tamaño: ".$pera->get_tamano()."</p>";
    ?>
</body>

</html>