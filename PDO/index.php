<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría PDO</title>
</head>

<body>
    <h1>Teoría PDO</h1>
    <?php
    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_foro2");


    /*try
    {
    $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
    die("<p>Imposible conectar. Error número:".mysqli_connect_errno()." : ".mysqli_connect_error()."</p></body></html>");
    }
    */

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die("<p>Imposible conectar. Error:" . $e->getMessage() . "</p></body></html>");
    }

    /*
    echo "<p>Conectado con éxito</p>";
    $usuario="masantos76";
    $clave=md5("123456");
    try
    {
    $consulta="select * from usuarios where usuario='".$usuario."' and clave='".$clave."'";
    $resultado=mysqli_query($conexion,$consulta);
    $tupla=array();
    if(mysqli_num_rows($resultado)>0)
    {
    $tupla=mysqli_fetch_assoc($resultado);
    }
    var_dump($tupla);
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    }
    catch(Exception $e)
    {
    $mensaje_error="<p>Imposible realizar la consulta. Error número:".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p></body></html>";
    mysqli_close($conexion);
    die($mensaje_error);
    }
    
    try
    {
    $consulta="select * from usuarios where usuario=? and clave=?";
    $sentencia=$conexion->prepare($consulta);
    $datos[]=$usuario;
    $datos[]=$clave;
    $sentencia->execute($datos);
    $tupla=array();
    if($sentencia->rowCount()>0)
    {
    $tupla=$sentencia->fetch(PDO::FETCH_ASSOC);
    // otras constantes: PDO::FETCH_NUM y PDO::FETCH_OBJ
    }
    var_dump($tupla);
    $sentencia=null;
    $conexion=null;
    }
    catch(PDOException $e)
    {
    $sentencia=null;
    $conexion=null;
    die("<p>Imposible realizar la consulta. Error ".$e->getMessage()."</p></body></html>");
    }
    
    try
    {
    $consulta="select * from usuarios";
    $resultado=mysqli_query($conexion,$consulta);
    
    while($tupla=mysqli_fetch_assoc($resultado))
    {
    echo "<p><strong>Usuario: </strong>".$tupla["usuario"]."</p>";
    }
    
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    }
    catch(Exception $e)
    {
    $mensaje_error="<p>Imposible realizar la consulta. Error número:".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p></body></html>";
    mysqli_close($conexion);
    die($mensaje_error);
    }
    
    try
    {
    $consulta="select * from usuarios";
    $sentencia=$conexion->prepare($consulta);
    $sentencia->execute();
    
    $respuesta=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    foreach( $respuesta as $tupla)
    {
    echo "<p><strong>Usuario: </strong>".$tupla["usuario"]."</p>";
    }
    
    $sentencia=null;
    $conexion=null;
    }
    catch(PDOException $e)
    {
    $sentencia=null;
    $conexion=null;
    die("<p>Imposible realizar la consulta. Error ".$e->getMessage()."</p></body></html>");
    }
    */

    $nombre = "Juan Pablo 2";
    $usuario = "mateos79";
    $clave = md5("123456");
    $email = "jhsdjhf79@jsd.es";
    /*try
    {
    $consulta="insert into usuarios (nombre,usuario,clave,email) values ('".$nombre."','".$usuario."','".$clave."','".$email."')";
    mysqli_query($conexion,$consulta);
    echo "<p>Usuario insertado con éxito con la id igual a : ".mysqli_insert_id($conexion)."</p>";
    mysqli_close($conexion);
    }
    catch(Exception $e)
    {
    $mensaje_error="<p>Imposible realizar la consulta. Error número:".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p></body></html>";
    mysqli_close($conexion);
    die($mensaje_error);
    }*/


    try {
        $consulta = "insert into usuarios (nombre,usuario,clave,email) values (?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $datos[] = $nombre;
        $datos[] = $usuario;
        $datos[] = $clave;
        $datos[] = $email;
        $sentencia->execute($datos);
        echo "<p>Usuario insertado con éxito con la id igual a : " . $conexion->lastInsertId() . "</p>";

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        die("<p>Imposible realizar la consulta. Error " . $e->getMessage() . "</p></body></html>");
    }
    ?>

</body>

</html>