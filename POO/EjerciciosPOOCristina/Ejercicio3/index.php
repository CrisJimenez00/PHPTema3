<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3 POO</title>
</head>

<body>
    <?php
    require "class_fruta.php";

    //Como en el constructor se pone el método imprimir(que no es usual), el orden sí afecta.
    echo "<h1>Información de mis frutas</h1>";

    //miramos como va antes
    echo "<p>Frutas creadas hasta ahora: " . Fruta::cuantaFruta() . "</p>";

    echo "<p>Creando la fruta...</p>";
    $pera = new Fruta("verde", "mediano");
    echo "<p>Frutas creadas hasta ahora: " . Fruta::cuantaFruta() . "</p>";

    //Creamos otra fruta para ver si funciona el contador
    echo "<p>Creando la fruta...</p>";
    $melon = new Fruta("amarillo", "grande");
    echo "<p>Frutas creadas hasta ahora: " . Fruta::cuantaFruta() . "</p>";

    //Destruimos con unset para ver si se resta(spoiler:no lo resta a no ser que hagamos un método __destruct)
    echo "<p>Destruyendo la fruta...</p>";
    unset($melon);
    echo "<p>Frutas creadas hasta ahora: " . Fruta::cuantaFruta() . "</p>";


    ?>
</body>

</html>