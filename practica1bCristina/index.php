<?php


if (isset($_POST["btnBorrar"])) {
    unset($_POST);
}
if (isset($_POST["btnGuardar"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_nacimiento = $_POST["nacimiento"] == "";
    $error_sexo = !isset($_POST["sexo"]);
    $error_comentario= $_POST["comentarios"] == "";
    $error_archivo = $_FILES["foto"]["name"] == "" || $_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000;
    $error_form = $error_nombre || $error_nacimiento || $error_sexo ||$error_comentario|| $error_archivo;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 1</title>
</head>

<body>

    <?php
    if (isset($_POST["btnGuardar"]) && !$error_form) {
        ?>
        <h1>DATOS ENVIADOS</h1>
        <p>El nombre enviado ha sido: 
            <?php echo $_POST["nombre"] ?>
        </p>
        <p>Ha nacido en:
            <?php echo $_POST["nacimiento"] ?>
        </p>
        <p>El sexo es:
            <?php echo $_POST["sexo"] ?>
        </p>
        </p>
        <p>
            <?php if(!isset($_POST["aficiones"])){
                echo "No has seleccionado ninguna afición";
            }else{
                echo "Las aficiones seleccionadas han sido:";
                echo "<ol>";
                for ($i=0; $i < count($_POST["aficiones"]) ; $i++) { 
                    echo "<li>".$_POST["aficiones"][$i]."</li>";
                }
                echo "</ol>";
            } ?>
        </p>
        </p>
        <p>El comentario ha sido:
            <?php echo $_POST["comentarios"] ?>
        </p>
        <p>---------------------</p>
        <h3>Foto</h3>
        <p>Error:
            <?php echo $_FILES["foto"]["error"] ?>
        </p>
        <p>Nombre:
            <?php echo $_FILES["foto"]["name"] ?>
        </p>
        <p>Tipo:
            <?php echo $_FILES["foto"]["type"] ?>
        </p>
        <p>Tamaño:
            <?php echo $_FILES["foto"]["size"] ?>
        </p>
        <?php
        $array_nombre = explode(".", $_FILES["foto"]["name"]);
        $extension = "";
        if (count($array_nombre) > 1)
            $extension = "." . strtolower(end($array_nombre));

        $nombre_unico = "img_" . md5(uniqid(uniqid(), true));

        $nombre_nuevo_archivo = $nombre_unico . $extension;

        @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "images/" . $nombre_nuevo_archivo);
        if (!$var) {
            echo "<p>La imagen no ha podido ser movida por falta de permisos</p>";
        } else {
            echo "<h3>La imagen ha sido subida con éxito</h3>";
            echo "<img height='200' src='images/" . $nombre_nuevo_archivo . "'/>";
        }



    } else { ?>
        <h1>Segundo formulario</h1>

        <!--Formulario-->
        <form action="index.php" method="post" enctype="multipart/form-data">


            <p>
                <!--Nombre-->
                <label for="nombre">Nombre:</label>
                <br />
                <input type="text" name="nombre" id="nombre" placeholder="Nombre..." value=<?php
                if (isset($_POST["nombre"]))
                    echo $_POST["nombre"];
                ?>>
                <?php
                if (isset($_POST["btnGuardar"]) && $error_nombre) {
                    echo "*Campo obligatorio*";
                }
                ?>
                <br />
                <!--Nacido en-->
                <label for="nacimiento">Nacido en:</label>
                <br />
                <select name="nacimiento" id="nacimiento">
                    <option value="Malaga" <?php if (isset($_POST["btnGuardar"]) && $_POST["nacimiento"] == "Malaga") {
                        echo "selected";
                    } ?>>Málaga</option>
                    <option value="Cadiz" <?php if (isset($_POST["btnGuardar"]) && $_POST["nacimiento"] == "Cadiz") {
                        echo "selected";
                    } ?>>Cádiz</option>
                    <option value="Granada" <?php if (isset($_POST["btnGuardar"]) && $_POST["nacimiento"] == "Granada") {
                        echo "selected";
                    } ?>>Granada</option>
                </select>

                <?php
                if (isset($_POST["btnGuardar"]) && $error_nacimiento) {
                    echo "*Debes seleccionar uno*";
                }
                ?>
            </p>
            <!--Sexo-->
            <p><label>Sexo:</label>
                <br />
                <input type="radio" name="sexo" id="hombre" value="hombre"><label for="hombre">Hombre</label>
                <br />
                <input type="radio" name="sexo" id="mujer" value="mujer"><label for="mujer">Mujer</label>
                <?php
                if (isset($_POST["btnGuardar"]) && $error_sexo) {
                    echo "*Campo obligatorio*";
                }
                ?>
            </p>
            <p><label>Aficiones:</label>
                <br />
                <input type="checkbox" name="aficiones[]" id="deportes" value="deportes" <?php if (isset($_POST["btnGuardar"]) && isset($_POST["aficiones"]) && in_array("deportes", $_POST["aficiones"])) {
                    echo "checked";
                } ?>><label
                    for="deportes">Deportes:</label>
                <br />
                <input type="checkbox" name="aficiones[]" id="lectura" value="lectura" <?php if (isset($_POST["btnGuardar"]) && isset($_POST["aficiones"]) && in_array("lectura", $_POST["aficiones"])) {
                    echo "checked";
                } ?>><label
                    for="lectura">Lectura:</label>
                <br />
                <input type="checkbox" name="aficiones[]" id="otros" value="otros" <?php if (isset($_POST["btnGuardar"]) && isset($_POST["aficiones"]) && in_array("otros", $_POST["aficiones"])) {
                    echo "checked";
                } ?>><label
                    for="otros">Otros:</label>
            </p>
            <p><label for="comentarios">Comentarios:</label>
                  <textarea class="form-control" name="comentarios" id="comentarios" rows="3"></textarea>
                <?php
                if (isset($_POST["btnGuardar"]) && $error_comentario) {
                    echo "*Campo obligatorio*";
                }
                ?>
            </p>

            <!--Foto-->
            <p><label for="foto">Incluir mi foto(Máx. 500KB)</label>
                <input type="file" name="foto" id="foto" accept="image/*">
                <?php
                if (isset($_POST["btnGuardar"]) && $error_archivo) {
                    if ($_FILES["foto"]["name"] != "") {
                        if ($_FILES["foto"]["error"])
                            echo "<span class='error'>Error en la subida del archivo</span>";
                        elseif (!getimagesize($_FILES["foto"]["tmp_name"]))
                            echo "<span class='error'>Error no has seleccionado un archivo imagen</span>";
                        else
                            echo "<span class='error'>Error el tamaño de la imagen seleccionada supera los 500KB </span>";
                    }elseif($_FILES["foto"]["name"] == ""){
                        echo "<span class='error'>*Error: Debes seleccionar un archivo* </span>";

                    }

                }
                ?>
            </p>
            
            <!--Botones-->
            <button type="submit" name="btnGuardar">Guardar Cambios</button>
            <button type="submit" name="btnBorrar">Borrar los datos introducidos</button>
        </form>
    <?php }
    ?>
</body>

</html>