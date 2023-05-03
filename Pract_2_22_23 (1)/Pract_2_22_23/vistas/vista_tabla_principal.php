<?php
// Código para la paginación
    
if(!isset($_SESSION["registros"]))
{    
    $_SESSION["registros"]=3;
    $_SESSION["buscar"]="";
    $_SESSION["pag"]=1;
}

if(isset($_POST["registros"]))
{
    $_SESSION["registros"]=$_POST["registros"];
    $_SESSION["buscar"]=$_POST["buscar"];
    $_SESSION["pag"]=1;
}

if(isset($_POST["pag"]))
{
    $_SESSION["pag"]=$_POST["pag"];
}

try
{
    if($_SESSION["registros"]==-1)
    {
        if($_SESSION["buscar"]=="")
            $consulta="select * from usuarios where tipo<>'admin'";
        else
            $consulta="select * from usuarios where tipo<>'admin' AND nombre LIKE '%".$_SESSION["buscar"]."%'";
    }
    else
    {
        $inicio=($_SESSION["pag"]-1)*$_SESSION["registros"];
        if($_SESSION["buscar"]=="")
            $consulta="select * from usuarios where tipo<>'admin' LIMIT ".$inicio.",".$_SESSION["registros"];
        else
            $consulta="select * from usuarios where tipo<>'admin' AND nombre LIKE '%".$_SESSION["buscar"]."%' LIMIT ".$inicio.",".$_SESSION["registros"];       
    }
    $sentencia=$conexion->prepare($consulta);
    $sentencia->execute();
    $usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia=null;
}
catch(PDOException $e)
{
    session_destroy();
    $sentencia=null;
    $conexion=null; 
    die("<p>Imposible realizar la consulta. Error:".$e->getMessage()."</p></body></html>");
}
?>

<form id="form_regs_buscar" action="index.php" method="post">
    <div>
        <label for="registros">Registros a Mostrar: </label>
        <select id="registros" name="registros" onchange="document.getElementById('form_regs_buscar').submit();">
            <option <?php if($_SESSION["registros"]==3) echo "selected";?> value="3">3</option>
            <option <?php if($_SESSION["registros"]==6) echo "selected";?> value="6">6</option>
            <option <?php if($_SESSION["registros"]==-1) echo "selected";?> value="-1">TODOS</option>
        </select>
    </div>
    <div>
        <input type="text" name="buscar" value="<?php echo $_SESSION["buscar"];?>"/> <button name="btnBuscar">Buscar</button>
    </div>
</form>
<?php
echo "<table id='tabla_principal'>";
echo "<tr>";
echo "<th>#</th><th>Foto</th><th>Nombre</th>";
echo "<th><form action='index.php' method='post'><button class='enlace' name='btnNuevo'>Usuario+</button></form></th>";
echo "</tr>";
foreach($usuarios as $tupla)
{
    echo "<tr>";
    echo "<td>".$tupla["id_usuario"]."</td>";
    echo "<td><img src='Img/".$tupla["foto"]."' alt='foto' title='foto'/></td>";
    echo "<td><form action='index.php' method='post'><button class='enlace' value='".$tupla["id_usuario"]."' name='btnListar' >".$tupla["nombre"]."</button></form></td>";
    echo "<td><form action='index.php' method='post'><input type='hidden' name='foto' value='".$tupla["foto"]."'/><button class='enlace' value='".$tupla["id_usuario"]."' name='btnBorrar'>Borrar</button> - <button class='enlace' value='".$tupla["id_usuario"]."' name='btnEditar'>Editar</button></form></td>";
    echo "</tr>";
}

echo "</table>";

if($_SESSION["registros"]!=-1)
{
    try
    {
        if($_SESSION["buscar"]=="")
            $consulta="select * from usuarios where tipo<>'admin'";
        else
            $consulta="select * from usuarios where tipo<>'admin' AND nombre LIKE '%".$_SESSION["buscar"]."%'";

        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
        $n_usuarios=$sentencia->rowCount();
        $sentencia=null;
    }
    catch(PDOException $e)
    {
        session_destroy();
        $sentencia=null;
        $conexion=null; 
        die("<p>Imposible realizar la consulta. Error:".$e->getMessage()."</p></body></html>");
    }

    $n_paginas=ceil($n_usuarios/$_SESSION["registros"]);

    if($n_paginas>1)
    {
        echo "<div id='bot_pag'>";
        echo "<form action='index.php' method='post'>";
        if($_SESSION["pag"]<>1)
        {
            echo "<button name='pag' value='1'>|<</button>";
            echo "<button name='pag' value='".($_SESSION["pag"]-1)."'><</button>";
        }

        for($i=1; $i<=$n_paginas; $i++)
        {
            if($_SESSION["pag"]==$i)
                echo "<button disabled name='pag' value='".$i."'>".$i."</button>";
            else
                echo "<button  name='pag' value='".$i."'>".$i."</button>";
        }
        
        if($_SESSION["pag"]<>$n_paginas)
        {
            echo "<button name='pag' value='".($_SESSION["pag"]+1)."'>></button>";
            echo "<button name='pag' value='".$n_paginas."'>>|</button>";
        }
        echo "</form>";
        echo "<div>";
    }
}
?>