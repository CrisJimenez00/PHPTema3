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

if(isset($_POST["btnContNuevo"]))
{
    $error_cod=$_POST["cod"]=="";
    if(!$error_cod)
    {
        $url=DIR_SERV."/repetido_insertar/producto/cod/".urlencode($_POST["cod"]);
        $respuesta=consumir_servicios_REST($url,"GET");
        $obj=json_decode($respuesta);
        if(!$obj)
            die(error_page("CRUD - SW","Listado de los Productos","<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta));

        if(isset($obj->mensaje_error))
            die(error_page("CRUD - SW","Listado de los Productos","<p>".$obj->mensaje_error."</p>"));
        
        $error_cod=$obj->repetido;
    }

    $error_nombre_corto=$_POST["nombre_corto"]=="";
    $error_descripcion=$_POST["descripcion"]=="";
    $error_PVP=$_POST["PVP"]==""||!is_numeric($_POST["PVP"])||$_POST["PVP"]<=0;

    $error_form=$error_cod ||$error_nombre_corto || $error_descripcion || $error_PVP;

    if(!$error_form)
    {
        $datos_insert['cod']=strtoupper($_POST["cod"]);
        $datos_insert['nombre']=$_POST["nombre"];
        $datos_insert['nombre_corto']=$_POST["nombre_corto"];
        $datos_insert['descripcion']=$_POST["descripcion"];
        $datos_insert['PVP']=$_POST["PVP"];
        $datos_insert['familia']=$_POST["familia"];

        $url=DIR_SERV."/producto/insertar";
        $respuesta=consumir_servicios_REST($url,"POST",$datos_insert);
        $obj=json_decode($respuesta);
        if(!$obj)
            die(error_page("CRUD - SW","Listado de los Productos","<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta));

        if(isset($obj->mensaje_error))
            die(error_page("CRUD - SW","Listado de los Productos","<p>".$obj->mensaje_error."</p>"));
        

        $_SESSION["accion"]="El producto con cod: <strong>".$obj->mensaje."</strong> se ha insertado con éxito";
        header("Location:index.php");
        exit;
    }

    
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

    if(isset($_POST["btnNuevo"])|| isset($_POST["btnContNuevo"]) )
    {
        $url=DIR_SERV."/familias";
        $respuesta=consumir_servicios_REST($url,"GET");
        $obj=json_decode($respuesta);
        if(!$obj)
            die("<p>Error consumiendo el servicio REST: ".$url."</p>".$respuesta."</body></html>");

        if(isset($obj->mensaje_error))
            die("<p>".$obj->mensaje_error."</p></body></html>");

        if(!$obj->familias)
        {
            echo "<form class='centrado centro' action='index.php' method='post'>";
            echo "<h2>Creando un Producto</h2>";
            echo "<p>Aún no hay familias de los productos en la BD. Inserte alguna antes de Añadir un nuevo producto</p>";
            echo "<p><button>Volver</button></p>";
            echo "</form>";
        }
        else
        {
        ?>
            <form class="centro" action="index.php" method="post">
                <h2>Creando un Producto</h2>
                <p>
                    <label for="cod">Código: </label>
                    <input type="text" maxlength="12" name="cod" id="cod" value="<?php if(isset($_POST["cod"])) echo $_POST["cod"];?>"/>
                    <?php
                        if(isset($_POST["btnContNuevo"]) && $error_cod)
                        {
                            if($_POST["cod"]=="")
                                echo "<span class='error'> Campo Vacío</span>";
                            else
                                echo "<span class='error'> Código repetido</span>"; 
                        }
                    ?>
                </p>
                <p>
                    <label for="nombre">Nombre: </label>
                    <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/>
                </p>
                <p>
                    <label for="nombre_corto">Nombre corto: </label>
                    <input type="text" name="nombre_corto" id="nombre_corto" value="<?php if(isset($_POST["nombre_corto"])) echo $_POST["nombre_corto"];?>"/>
                    <?php
                        if(isset($_POST["btnContNuevo"]) && $error_nombre_corto)
                                echo "<span class='error'> Campo Vacío</span>";
                    ?>
                </p>
                <p>
                    <label for="descripcion">Descripción: </label>
                    <textarea name="descripcion" id="descripcion"><?php if(isset($_POST["descripcion"])) echo $_POST["descripcion"];?></textarea>
                    <?php
                        if(isset($_POST["btnContNuevo"]) && $error_descripcion)
                                echo "<span class='error'> Campo Vacío</span>";
                    ?>
                </p>
                <p>
                    <label for="PVP">PVP: </label>
                    <input type="text"  name="PVP" id="PVP" value="<?php if(isset($_POST["PVP"])) echo $_POST["PVP"];?>"/>
                    <?php
                        if(isset($_POST["btnContNuevo"]) && $error_PVP)
                        {
                            if($_POST["PVP"]=="")
                                echo "<span class='error'> Campo Vacío</span>";
                            else
                                echo "<span class='error'> Cuantía no válida</span>"; 
                        }
                    ?>
                </p>
                <p>
                    <label for="familia">Seleccione una familia: </label>
                    <select id="familia" name="familia">
                    <?php
                    foreach ($obj->familias as $tupla) 
                    {
                        if(isset($_POST["familia"]) && $_POST["familia"]==$tupla->cod)
                            echo "<option selected value='".$tupla->cod."'>".$tupla->nombre."</option>";
                        else
                            echo "<option value='".$tupla->cod."'>".$tupla->nombre."</option>";
                    }
                    ?>
                    </select>
                </p>
                <p>
                    <button>Volver</button> <button name="btnContNuevo">Continuar</button>
                </p>
            </form>
        
        <?php
        }
    }
    
    if(isset($_POST["btnEditar"]))
    {
        echo "Formulario para editar";
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