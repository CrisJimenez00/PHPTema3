<?php
function repetido($conexion, $tabla,$columna,$valor,$columna_clave=null,$valor_clave=null)
{
    if(isset($columna_clave))
        $consulta="select ".$columna." from ".$tabla." where ".$columna."='".$valor."' AND ".$columna_clave."<>'".$valor_clave."'";
    else
        $consulta="select ".$columna." from ".$tabla." where ".$columna."='".$valor."'";
    try
    {
        $resultado=mysqli_query($conexion,$consulta);
        $respuesta=mysqli_num_rows($resultado)>0;
        mysqli_free_result($resultado);
    }
    catch(Exception $e)
    {
        $respuesta ="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion); 
    }
        
    return $respuesta;
}

function pag_error($title,$encabezado,$mensaje)
{
    return "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'/><title>".$title."</title></head><body><h1>".$encabezado."</h1><p>".$mensaje."</p></body></html>";
    
}

?>