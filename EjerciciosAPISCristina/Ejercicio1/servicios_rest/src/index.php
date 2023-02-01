<?php

require __DIR__ . '/Slim/autoload.php';
require "src/bd_config.php";
require "src/funciones.php";

$app = new \Slim\App;

//Todos los productos (a):

$app->get('/productos', function () {

    //$datos["cod"]=$request->getParam('cod');
    echo json_encode(obtener_productos());

});

//Info de un producto en concreto (b):

$app->get('/producto/{cod}', function ($request) {

    $datos[] = $request->getParam('cod');
    echo json_encode(obtener_producto($request->getAttribute("cod")));


});

//Insertar un producto (c):

$app->put('producto/insertar', function ($request) {
    $datos[] = $request->getParam('cod');
    $datos[] = $request->getParam('nombre');
    $datos[] = $request->getParam('nombre_corto');
    $datos[] = $request->getParam('descripcion');
    $datos[] = $request->getParam('PVP');
    $datos[] = $request->getParam('familia');
    echo json_encode(insertar_producto($datos));
});

$app->put('/productos/actualizar/{cod}', function ($request) {
    $datos[] = $request->getParam('nombre');
    $datos[] = $request->getParam('nombre_corto');
    $datos[] = $request->getParam('descripcion');
    $datos[] = $request->getParam('PVP');
    $datos[] = $request->getParam('familia');
    $datos[] = $request->getAttribute('cod');
    echo json_encode(actualizar_producto($datos));

});

$app->delete('/producto/borrar/{cod}', function ($request) {
    echo json_encode(borrar_producto($request->getAttribute('cod')));
});
/*
EJERCICIOS
$app->get('/familias');
$app->get('/repetir_inset/{tabla}/{columna}/{valor}',...);
$app->get('/repetir_edit/{tabla}/{columna}/{valor}/{colum_claves}/{valor_clave}',...);;
*/
$app->get('/familias/{cod}', function ($request) { 
    echo json_encode(obtener_producto($request->getAttribute('cod')));
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>