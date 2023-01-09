<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6 POO</title>
</head>
<body>
    <?php
    require "class_menu.php";
    $m = new Menu();
    $m->carga("https://www.nintendo.es/", "Nintendo");
    $m->carga("https://www.marca.com/", "Marca");
    $m->carga("https://www.msn.com/es-es", "MSN");
    $m->vertical();
    $m->horizontal();
    ?>
</body>
</html>