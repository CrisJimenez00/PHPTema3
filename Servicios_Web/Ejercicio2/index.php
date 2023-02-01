<?php
session_name("Ejer2_SW_Curso22_23");
session_start();

function consumir_servicios_REST($url,$metodo,$datos=null)
{
    $llamada=curl_init();
    curl_setopt($llamada,CURLOPT_URL,$url);
    curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
    if(isset($datos))
        curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
    $respuesta=curl_exec($llamada);
    curl_close($llamada);
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
        <h1>'.$cabecera.'</h1>'.$mensaje.'
    </body>
    </html>';
}

define("DIR_SERV","http://localhost/Proyectos/Servicios_Web/Ejercicio1/servicios_rest_ejer1");

if(isset($_POST["btnContBorrar"]))
{
    $url=DIR_SERV."/producto/borrar/".urlencode($_POST["btnContBorrar"]);
        $respuesta=consumir_servicios_REST($url,"DELETE");
        $obj=json_decode($respuesta);
        if(!$obj)
            die(error_page("CRUD - SW","Listado de los Productos","<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta));

        if(isset($obj->mensaje_error))
            die(error_page("CRUD - SW","Listado de los Productos","<p>".$obj->mensaje_error."</p>"));
        
        $_SESSION["accion"]="El producto se ha borrado con éxito";
        header("Location:index.php");
        exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - SW</title>
    <style>
        table,th,td{border:1px solid black}
        table{border-collapse:collapse}
        .centrado{text-align:center}
        .centro{width:80%;margin:0 auto}
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
        .mensaje{color:blue;font-size:1.25em}
    </style>
</head>
<body>
    <h1 class="centrado">Listado de los Productos</h1>
    <?php
    if(isset($_POST["btnListar"]))
    {
        echo "<div class='centro'>";
        echo "<h2>Información del producto: ".$_POST["btnListar"]."</h2>";

        $url=DIR_SERV."/producto/".urlencode($_POST["btnListar"]);
        $respuesta=consumir_servicios_REST($url,"GET");
        $obj=json_decode($respuesta);
        if(!$obj)
            die("<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta."</div></body></html>");

        if(isset($obj->mensaje_error))
            die("<p>".$obj->mensaje_error."</p></div></body></html>");

        if(!$obj->producto)
            echo "<p>El producto ya no se encuentra en la BD</p>";
        else
        {
            $url=DIR_SERV."/familia/".urlencode($obj->producto->familia);
            $respuesta=consumir_servicios_REST($url,"GET");
            $obj2=json_decode($respuesta);
            if(!$obj2)
                die("<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta."</div></body></html>");

            if(isset($obj2->mensaje_error))
                die("<p>".$obj2->mensaje_error."</p></div></body></html>");

            if(!$obj2->familia)
                $familia=$obj->producto->familia;
            else
                $familia=$obj2->familia->nombre;
            

            echo "<p>";
            echo "<strong>Nombre: </strong>".$obj->producto->nombre."<br/>";
            echo "<strong>Nombre corto: </strong>".$obj->producto->nombre_corto."<br/>";
            echo "<strong>Descripción: </strong>".$obj->producto->descripcion."<br/>";
            echo "<strong>PVP: </strong>".$obj->producto->PVP."€<br/>";
            echo "<strong>Familia: </strong>".$familia."<br/>";
            echo "</p>";
        }
        echo "<form action='index.php' method='post'><button>Volver</button></form>";
        echo "</div>";
    }
    
    if(isset($_POST["btnBorrar"]))
    {
        echo "<div class='centro centrado'>";
        echo "<p>Se dispone usted a borrar el producto: ".$_POST["btnBorrar"]."</p>";
        echo "<form action='index.php' method='post'>";
        echo "<p>¿Estás Seguro?</p>";
        echo "<p><button>Cancelar</button><button name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Continuar</button></p>";
        echo "</form>"; 
        echo "</div>";
    }

    if(isset($_POST["btnNuevo"]))
    {
        echo "Formulario para insertar nuevo Producto";

    }
    
    
    $url=DIR_SERV."/productos";
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj)
        die("<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta."</body></html>");

    if(isset($obj->mensaje_error))
        die("<p>".$obj->mensaje_error."</p></body></html>");

    echo "<table class='centrado centro'>";
    echo "<tr><th>COD</th><th>Nombre</th><th>PVP</th><th><form action='index.php' method='post'><button class='enlace' name='btnNuevo'>Producto+</button></form></th></tr>";

    foreach($obj->productos as $tupla)
    {
        echo "<tr>";
        echo "<td><form action='index.php' method='post'><button name='btnListar' class='enlace' value='".$tupla->cod."'>".$tupla->cod."</button></form></td>";
        echo "<td>".$tupla->nombre_corto."</td>";
        echo "<td>".$tupla->PVP."</td>";
        echo "<td><form action='index.php' method='post'><button name='btnBorrar' class='enlace' value='".$tupla->cod."'>Borrar</button> - <button name='btnEditar' class='enlace' value='".$tupla->cod."'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "<table>";

    if(isset($_SESSION["accion"]))
    {
        echo "<p class='mensaje centro centrado'>¡¡ ".$_SESSION["accion"]."!!</p>";
        unset($_SESSION["accion"]);
    }
    ?>
    
</body>
</html>