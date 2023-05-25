<?php
require "bd_config.php";


function logueado($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select * from usuarios where usuario=? and clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);

            if($sentencia->rowCount()>0)
            {
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
                
            }
            else
                $respuesta["mensaje"]="Usuario no registrado en BD";

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}


function login($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select * from usuarios where usuario=? and clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);

            if($sentencia->rowCount()>0)
            {
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
                session_name("api_blog_exam_22_23");
                session_start();
                $_SESSION["usuario"]=$respuesta["usuario"]["usuario"];
                $_SESSION["clave"]=$respuesta["usuario"]["clave"];
                $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];
                $respuesta["api_session"]=session_id();
            }  
            else
                $respuesta["mensaje"]="Usuario no registrado en BD";

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}

function insertar_usuario($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="insert into usuarios (usuario, clave, email) values(?,?,?)";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["mensaje"]="Usuario registrado correctamente en BD";

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}


function obtener_comentarios()
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select comentarios.*, usuarios.usuario, noticias.titulo from comentarios, usuarios, noticias where comentarios.idUsuario=usuarios.idusuario and comentarios.idNoticia=noticias.idNoticia order by comentarios.idComentario";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute();

            $respuesta["comentarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}

function obtener_usuarios($columna,$valor)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select * from usuarios where ".$columna."=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$valor]);

            if($sentencia->rowCount()>0)
                $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            else
                $respuesta["mensaje"]="No existe un usuario con ".$columna."=".$valor;

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}


function obtener_comentarios_noticia($id)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select comentarios.*, usuarios.usuario from comentarios, usuarios where comentarios.idUsuario=usuarios.idusuario and idNoticia=? order by comentarios.fCreacion";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$id]);

            
            $respuesta["comentarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}

function obtener_usuario($id)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select * from usuarios where idusuario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$id]);

            if($sentencia->rowCount()>0)
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            else
                $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";
            

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}

function obtener_noticia($id)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select noticias.*, usuarios.usuario, categorias.valor from noticias, usuarios, categorias where noticias.idUsuario=usuarios.idusuario and noticias.idCategoria=categorias.idCategoria and noticias.idNoticia=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$id]);

            if($sentencia->rowCount()>0)
                $respuesta["noticia"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            else
                $respuesta["mensaje"]="La noticia no se encuentra registrada en la BD";
            

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}

function obtener_categoria($id)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select * from categorias where idCategoria=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$id]);

            if($sentencia->rowCount()>0)
                $respuesta["categoria"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            else
                $respuesta["mensaje"]="La categoria no se encuentra registrada en la BD";
            

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}
function obtener_comentario($id)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="select * from comentarios where idComentario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$id]);

            if($sentencia->rowCount()>0)
                $respuesta["comentario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            else
                $respuesta["mensaje"]="El comentario no se encuentra registrado en la BD";
            

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}


function actualizar_comentario($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="update comentarios set estado=? where idComentario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);

           
          
            $respuesta["mensaje"]="El comentario ha sido actualizado correctamente";
            

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}


function borrar_comentario($id)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="delete from comentarios where idComentario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$id]);

           
          
            $respuesta["mensaje"]="El comentario ha sido borrado correctamente";
            

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}


function insertar_comentario($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            $consulta="insert into comentarios (comentario, idUsuario, idNoticia,estado) values(?,?,?,?)";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);

           
          
            $respuesta["mensaje"]="El comentario ha sido insertado correctamente";
            

            $sentencia=null;
            $conexion=null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }
        

    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar a la BD. Error:".$e->getMessage();
    }

    return $respuesta;
}
?>
