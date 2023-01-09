<?php
//Conectamos primero y controlamos el error de conexion
try {
    $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_exam_colegio");
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    die("No se puede conectar con la base de datos. Error nº " . mysqli_connect_errno() . ": " . mysqli_connect_error());
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 22_23</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th {
            background-color: darkgray;
        }

        td button {
            text-decoration: underline;
            color: blue;
            background-color: white;
            border: 0px;
        }
    </style>
</head>

<body>
    <h1>Notas de los alumnos</h1>
    <?php
    //SELECT
    $consulta = "select*from alumnos";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado == "") {
        echo "<p>En estos momentos no tenemos ningún alumno registrado en la BD.</p>";
    } else {
        try {
            echo '<form action="index.php" method="post">';
            echo "Seleccione un Alumno: ";
            echo '<select name="alumno" id="alumno" >';
            while ($tupla = mysqli_fetch_assoc($resultado)) {
                echo '<option id=' . $tupla["cod_alum"] . 'value=' . $tupla["cod_alum"] . '>' . $tupla["nombre"] . '</option>';
            }
            echo '</select>';
            echo '<button type="submit" name="btnListar">Ver notas</button></form>';
            mysqli_free_result($resultado);

        } catch (Exception $e) {
            $mensaje = "Error nº " . mysqli_errno($conexion) . ":" . mysqli_error($conexion);
            mysqli_close($conexion);
            die($mensaje);
        }
    }

    //ELIMINAR
    if (isset($_POST["btnBorrar"])) {
        try {
            echo "¿Está seguro que desea eliminar al alumno?";
            echo "<form action='index.php' method='post'><button type='submit' name='btnVolver'>Volver</button></form>";
            echo "<button type='submit' name='btnContBorrado'>Continuar</button>";
            if (isset($_POST["btnContBorrado"])) {
                $consulta = "delete notas.nota from notas where notas.cod_alum=alumnos.cod_alum and notas.cod_asig=asignaturas.cod_asig " ;
                $resultado = mysqli_query($conexion, $consulta);
                echo "Se ha eliminado correctamente";
                echo "<form action='index.php' method='post'><button type='submit' name='btnVolver'>Volver</button></form>";
            }
        } catch (Exception $e) {
            $mensaje = "Error nº " . mysqli_errno($conexion) . ":" . mysqli_error($conexion);
            mysqli_close($conexion);
            die($mensaje);
        }
    }

    //LISTAR
    if (isset($_POST["btnListar"])) {
        try {

            $consulta = "select alumnos.nombre, asignaturas.denominacion, notas.cod_alum, nota from notas, alumnos, asignaturas where notas.cod_alum=alumnos.cod_alum and notas.cod_asig=asignaturas.cod_asig ";
            $resultado = mysqli_query($conexion, $consulta);
            while ($tupla = mysqli_fetch_assoc($resultado)) {
                echo "<h2>Notas del alumno " . $tupla["nombre"] . "</h2>";
                echo "<table>";
                while ($tupla = mysqli_fetch_assoc($resultado)) {
                    echo "<tr><th>Asignatura</th><th>Nota</th><th>Accion</th></tr>";
                    echo "<tr>";
                    echo "<td>" . $tupla["denominacion"] . "</td>";
                    echo "<td>" . $tupla["nota"] . "</td>";
                    echo "<td><form action='index.php' method='post'><button type='submit' name='btnEditar'>Editar</button></form>-<form action='index.php' method='post'><button type='submit' name='btnBorrar' >Borrar</button></form></td>";
                    echo "</tr>";
                }
                echo "</table>";
            }

        } catch (Exception $e) {
            $mensaje = "Error nº " . mysqli_errno($conexion) . ":" . mysqli_error($conexion);
            mysqli_close($conexion);
            die($mensaje);
        }

    }
    //EDITAR
    if (isset($_POST["btn"])) {


    }




    mysqli_close($conexion);
    ?>
</body>

</html>