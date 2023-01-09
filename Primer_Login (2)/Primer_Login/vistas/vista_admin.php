<?php
if (isset($_POST["btnSalir"])) {
    session_destroy();
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
    <title>Primer Login</title>
    <style>
        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .enlinea {
            display: inline
        }

        table,
        td,
        th,
        tr {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <h1>Primer Login</h1>
    <div>

        Bienvenido <strong>
            <?php echo $datos_usuario_log["usuario"]; ?>
        </strong> -
        <form class="enlinea" action="index.php" method="post">
            <button class='enlace' name='btnSalir'>Salir</button>
        </form>

        <?php

        $consulta = "select * from usuarios where tipo='normal'";
        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) <= 0) {

            echo "<p>No hay usuarios normales en la base de datos</p>";

        } else { 

            echo "<table>";
            echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";

            while ($tupla = mysqli_fetch_assoc($resultado)) {

                echo "<tr>";

                echo "<td>" . $tupla["usuario"] . "</td>";
                echo "<td>" . $tupla["id_usuario"] . "</td>";
                echo "<td>" . $tupla["id_usuario"] . "</td>";

                echo "</tr>";

            }

            echo "</table>";
        }
        ?>

    </div>
</body>

</html>