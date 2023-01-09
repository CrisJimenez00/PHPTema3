<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5 POO</title>
</head>

<body>
    <?php
    require "class_empleado.php";
    $empleado1 = new Empleado("Jose Martin", 34000);
    $empleado2 = new Empleado("Pepe Fernández", 1000);
    $empleado1->pagaImpuestos();
    $empleado2->pagaImpuestos();
    ?>
</body>

</html>