<?php
require "src/funciones.php";
require __DIR__ . '/Slim/autoload.php';


$app= new \Slim\App;





$app->post('/login',function($request){
    
    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");


    echo json_encode(login($datos));

});
$app->get('/obtener_usuarios',function($request){
    $datos[]=$request->getParam("is_usuario");
    $datos[]=$request->getParam("foto");
$datos[]=$request->getParam("nombre");

    echo json_encode(obtener_usuarios($datos));

});
// Una vez creado servicios los pongo a disposición
$app->run();
?>