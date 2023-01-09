<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4 POO</title>
</head>

<body>
    <?php

    //Importamos las clases necesarias
    require "class_fruta.php"; //va a dar error porque está requerido 2 veces(en clase uva y en index)
    require "class_uva.php";

    //Como en el constructor se pone el método imprimir(que no es usual), el orden sí afecta.
    echo "<h1>Información de mis frutas</h1>";

    //Miramos como funciona previamente
    echo "<p>Frutas creadas hasta ahora: " . Fruta::cuantaFruta() . "</p>";

    echo "<p>Creando la fruta...</p>";
    $pera = new Fruta("verde", "mediano");
    echo "<p>Frutas creadas hasta ahora: " . Fruta::cuantaFruta() . "</p>";

    //Creamos otra fruta para ver si funciona el contador
    echo "<p>Creando la fruta...</p>";
    $melon = new Fruta("amarillo", "grande");
    echo "<p>Frutas creadas hasta ahora: " . Fruta::cuantaFruta() . "</p>";
    echo "<p>--------------------------------------------------------<br/></p>"; //Uso esta línea para facilitar la lectura en el html

    //Destruimos con unset para ver si se resta(spoiler:no lo resta a no ser que hagamos un método __destruct)
    echo "<p><strong>Destruyendo</strong> la fruta...</p>";
    unset($melon);
    echo "<p>Frutas creadas hasta ahora: " . Fruta::cuantaFruta() . "</p>";
    echo "<p>--------------------------------------------------------<br/></p>";


    //Ejemplo con Uva
    //Con semillas
    echo "<p>Creando una uva con semillas...</p>";
    $uva_sem = new Uva("verde", "pequeña", true);
    echo "<p>Frutas creadas hasta ahora: " . Fruta::cuantaFruta() . "</p>";

    //Sin semillas
    echo "<p>Creando una uva sin semillas...</p>";
    $uva_sin_sem = new Uva("verde", "pequeña", false);
    echo "<p>Frutas creadas hasta ahora: " . Fruta::cuantaFruta() . "</p>";
    echo "<p>--------------------------------------------------------<br/></p>";

    echo "<h2>Info de la Uva con semillas</h2>";
    $uva_sem->imprimir();
    echo "<h2>Info de la Uva sin semillas</h2>";
    $uva_sin_sem->imprimir();
    echo "<p>--------------------------------------------------------<br/></p>";

    ?>
</body>

</html>