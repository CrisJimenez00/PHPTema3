<?php 
    $url=DIR_SERV."/comentarios";
    $respuesta=consumir_servicios_REST($url,"GET",$_SESSION["api_session"]);
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
        session_destroy();
        die("<p>Error consumiendo el servicio: ".$url."</p></body></html>");
    }
    if(isset($obj->mensaje_error))
    {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
        session_destroy();
        die("<p>".$obj->mensaje_error."</p></body></html>");
    }

    if(isset($obj->no_login))
    {
        session_destroy();
        die("<p>El tiempo de sesión de la API ha expirado. Vuelva a <a href='index.php'>loguearse</a>.</p></body></html>");
        
    }

    echo "<h2>Todos los comentarios</h2>";

    echo "<table id='tabla_comentarios'>";
    echo "<tr><th>ID</th><th>Comentarios</th><th>Opción</th></tr>";
    foreach ($obj->comentarios as $tupla)
    {
        echo "<tr>";
        echo "<td>".$tupla->idComentario."</td>";
        echo "<td>";
        echo $tupla->comentario."<br/>Dijo <strong>".$tupla->usuario."</strong> en ";
        echo "<form class='enlinea' action='gest_comentarios.php' method='post'>";
        echo "<button name='btnVerNoticia' value='".$tupla->idNoticia."' class='enlace'>".$tupla->titulo."</button></form>";
        echo "</td>";
        echo "<td><form action='gest_comentarios.php' method='post'>";
        if($tupla->estado=="sin validar")
            echo "<button class='enlace' value='".$tupla->idComentario."' name='btnAprobar'>Aprobar</button> - ";
        echo "<button class='enlace' value='".$tupla->idComentario."' name='btnBorrar'>Borrar</button>";
        echo "</form></td>";
        echo "</tr>";
    }

    echo "</table>";
?>