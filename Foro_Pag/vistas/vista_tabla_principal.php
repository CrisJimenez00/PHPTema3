<?php
if(!isset($_SESSION["regs_x_pag"]))
{
    $_SESSION["regs_x_pag"]=3;
    $_SESSION["buscar"]="";
}

if(isset($_POST["regs_x_pag"]))
{
    $_SESSION["regs_x_pag"]=$_POST["regs_x_pag"];
    $_SESSION["buscar"]=$_POST["buscar"];
    $_SESSION["pag"]=1;
}


if(!isset($_SESSION["pag"]))
    $_SESSION["pag"]=1;

if(isset($_POST["pag"]))
    $_SESSION["pag"]=$_POST["pag"];

$inicio=($_SESSION["pag"]-1)*$_SESSION["regs_x_pag"];



?>
<form class="centrar flexible" method="post" action="index.php">
    <div>
        <label for="regs_x_pag">Registros a mostrar:</label>
        <select name="regs_x_pag" id="regs_x_pag" onchange="document.getElementById('btnBuscar').click();">
            <option <?php if($_SESSION["regs_x_pag"]==3) echo "selected";?> value="3">3</option>
            <option <?php if($_SESSION["regs_x_pag"]==6) echo "selected";?> value="6">6</option>
            <option <?php if($_SESSION["regs_x_pag"]==-1) echo "selected";?> value="-1">TODOS</option>
        </select>
    </div>
    <div>
        <input type="text" name="buscar" value="<?php echo $_SESSION["buscar"];?>"/>
        <button id="btnBuscar" type="submit">Buscar</button>
    </div>    
</form>
<?php


try
{
    if($_SESSION["regs_x_pag"]==-1)
        if($_SESSION["buscar"]=="")
            $consulta="select * from usuarios";
        else
            $consulta="select * from usuarios where nombre like '%".$_SESSION["buscar"]."%'";
    else
        if($_SESSION["buscar"]=="")
            $consulta="select * from usuarios where  nombre like '%".$_SESSION["buscar"]."%' limit ".$inicio.",".$_SESSION["regs_x_pag"];
        else
            $consulta="select * from usuarios where nombre like '%".$_SESSION["buscar"]."%' limit ".$inicio.",".$_SESSION["regs_x_pag"];
    
    $resultado=mysqli_query($conexion,$consulta);


    echo "<table class='txt_centrado centrar'>";
    echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";
    while($tupla=mysqli_fetch_assoc($resultado))
    {
        echo "<tr>";
        echo "<td><form action='index.php' method='post'><button type='submit' class='enlace' name='btnListar' value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</button></form></td>";
        echo "<td><form action='index.php' method='post'>";
        echo "<input type='hidden' name='nombre' value='".$tupla["nombre"]."'/>";
        echo "<button type='submit' name='btnBorrar' value='".$tupla["id_usuario"]."'><img src='img/borrar.png' alt='Borrar' title='Borrar usuario'/></button></form></td>";
        echo "<td><form action='index.php' method='post'><button type='submit' name='btnEditar' value='".$tupla["id_usuario"]."'><img src='img/editar.png' alt='Editar' title='Editar usuario'/></button></form></td>";
        echo "</tr>";
    }
    echo "</table>";

   
    
   


}
catch(Exception $e)
{
    $mensaje="<p>Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
    mysqli_close($conexion);
    die($mensaje); 
}

if($_SESSION["regs_x_pag"]!=-1)
{
    try
    {
        if($_SESSION["buscar"]=="")
            $consulta="select * from usuarios";
        else
            $consulta="select * from usuarios where nombre like '%".$_SESSION["buscar"]."%'";

        $resultado=mysqli_query($conexion,$consulta);
        $n_total_regs=mysqli_num_rows($resultado);
        $n_total_pags=ceil($n_total_regs/$_SESSION["regs_x_pag"]);
        if($n_total_pags>1)
        {
            echo "<form class='txt_centrado centrar' method='post' action='index.php'>";
            if($_SESSION["pag"]>1)
            {
                echo "<button type='submit' name='pag' value='1'>|<</button>";
                echo "<button type='submit' name='pag' value='".($_SESSION["pag"]-1)."'><</button>";
            }
            for($i=1;$i<=$n_total_pags;$i++)
            {
                if($i==$_SESSION["pag"])
                    echo "<button disabled type='submit' name='pag' value='".$i."'>".$i."</button>";
                else
                    echo "<button type='submit' name='pag' value='".$i."'>".$i."</button>";
            }
            if($_SESSION["pag"]<$n_total_pags)
            {
                echo "<button type='submit' name='pag' value='".($_SESSION["pag"]+1)."'>></button>";
                echo "<button type='submit' name='pag' value='".$n_total_pags."'>>|</button>";
            }

            echo "</form>";
        }

    }
    catch(Exception $e)
    {
        $mensaje="<p>Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
        mysqli_close($conexion);
        die($mensaje); 
    }
}
mysqli_free_result($resultado);

?>