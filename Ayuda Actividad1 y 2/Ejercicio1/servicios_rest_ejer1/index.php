<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones.php";

$app= new \Slim\App;

$app->get('/productos',function(){

   
    echo json_encode(obtener_productos());

});

$app->get('/producto/{cod}',function($request){

   
    echo json_encode(obtener_producto($request->getAttribute('cod')));

});

$app->post('/producto/insertar',function($request){

    $datos[]=$request->getParam('cod');
    $datos[]=$request->getParam('nombre');
    $datos[]=$request->getParam('nombre_corto');
    $datos[]=$request->getParam('descripcion');
    $datos[]=$request->getParam('PVP');
    $datos[]=$request->getParam('familia');

    echo json_encode(insertar_producto($datos));

});

$app->put('/producto/actualizar/{cod}',function($request){
    
    $datos[]=$request->getParam('nombre');
    $datos[]=$request->getParam('nombre_corto');
    $datos[]=$request->getParam('descripcion');
    $datos[]=$request->getParam('PVP');
    $datos[]=$request->getParam('familia');
    $datos[]=$request->getAttribute('cod');
    echo json_encode(actualizar_producto($datos));
});

$app->delete('/producto/borrar/{cod}',function($request){
  
    echo json_encode(borrar_producto($request->getAttribute('cod')));

});

$app->get('/familias',function(){

    
    echo json_encode(obtener_familias());

});

$app->get('/familia/{cod}',function($request){

   
    echo json_encode(obtener_familia($request->getAttribute('cod')));

});

$app->get('/repetido_insert/{tabla}/{columna}/{valor}',function($request){

    echo json_encode(repetido($request->getAttribute('tabla'),$request->getAttribute('columna'),$request->getAttribute('valor')));

});

$app->get('/repetido_edit/{tabla}/{columna}/{valor}/{columna_clave}/{valor_clave}',function($request){

    
    echo json_encode(repetido($request->getAttribute('tabla'),$request->getAttribute('columna'),$request->getAttribute('valor'),$request->getAttribute('columna_clave'),$request->getAttribute('valor_clave')));

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>