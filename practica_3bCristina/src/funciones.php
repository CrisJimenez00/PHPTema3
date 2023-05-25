<?php

function LetraNIF($dni) 
{  
     return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1); 
} 

function dni_bien_escrito($texto)
{
    $dni=strtoupper($texto);
    return strlen($dni)==9 && is_numeric(substr($dni,0,8)) && substr($dni,-1)>="A" && substr($dni,-1)<="Z"; 

}

function dni_valido($dni)
{
    return LetraNIF(substr($dni,0,8))==strtoupper(substr($dni,-1));
}

function repetido_reg($conexion,$columna, $valor)
{
    try
    {
        $consulta="select * from usuarios where ".$columna."=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor]);
        $respuesta=$sentencia->rowCount()>0;
        $sentencia=null;
      
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $respuesta="Imposible realizar la consulta. Error:".$e->getMessage();
    }
  
 
    return $respuesta;
}

function repetido_edit($conexion,$columna, $valor,$columna_clave, $valor_clave)
{
    try
    {
        $consulta="select * from usuarios where ".$columna."=? and ".$columna_clave."<>?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor,$valor_clave]);
        $respuesta=$sentencia->rowCount()>0;
        $sentencia=null;
      
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $respuesta="Imposible realizar la consulta. Error:".$e->getMessage();
    }
  
 
    return $respuesta;
}

function error_page($title,$cabecera,$mensaje)
{
    return '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title>
    </head>
    <body>
        <h1>'.$cabecera.'</h1><p>'.$mensaje.'</p>
    </body>
    </html>';
}
?>