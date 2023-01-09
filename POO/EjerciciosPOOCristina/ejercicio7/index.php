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
    require "class_videoclub.php";
    $peli = new Videoclub("Pelicula1", "Director1", 9.99, false, '2023/1/17');
    echo "<p><strong>Titulo </strong>: ".$peli->get_titulo()."</p>";
    echo "<p><strong>Director </strong>: ".$peli->get_director()."</p>";
    echo "<p><strong>Precio </strong>: ".$peli->get_precio()."</p>";
    if($peli->get_alquilada()){
        echo "<p><strong>Estado </strong>: Disponible</p>";
    }else{
        echo "<p><strong>Estado </strong>: Alquilada</p>";
        echo "<p><strong>Fecha prevista de devolucion </strong>: ".$peli->get_fechaPrevDev()."</p>";
        echo "<p><strong>Recargo actual </strong>: ".$peli->calcularRecargo()." €</p>";
    }
    ?>
 </body>
 </html>