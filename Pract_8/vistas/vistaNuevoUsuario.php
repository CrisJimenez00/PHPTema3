
<h2 class='centrar'>Agregar Nuevo Usuario</h2>
<form class='centrar' method="post" action="index.php" enctype="multipart/form-data">

    <p><label for="nombre">Nombre: </label><br />
    <input type="text" name="nombre" id="nombre" placeholder="Nombre..." size="30" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/>
    <?php
        if(isset($_POST["nombre"]) && $error_nombre)
            echo "<span class='error'>* Campo vacío *</span>";
    ?>
    </p>
    <p>
    <label for="usuario">Usuario: </label><br />
    <input type="text" name="usuario" id="usuario" placeholder="Usuario..." value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
    <?php
        if(isset($_POST["usuario"]) && $error_usuario)
            if($_POST["usuario"]=="")
                echo "<span class='error'>* Campo vacío *</span>";
            else echo "<span class='error'>* Usuario repetido *</span>";
    ?>
    </p>
    <p>
    <label for="clave">Contraseña: </label><br />
    <input type="password" name="clave" id="clave" placeholder="Contraseña..." />
    <?php
        if(isset($_POST["clave"]) && $error_clave)
            echo "<span class='error'>* Campo vacío *</span>";
    ?>
    </p>
    <p>
    <label for="dni">DNI: </label><br />
    <input type="dni" name="dni" id="dni" placeholder="DNI: 11223344A" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>"/>
    <?php
        if(isset($_POST["dni"]) && $error_dni)
        {
            if($_POST["dni"]=="")
                echo "<span class='error'>* Campo vacío *</span>";
            elseif(!bien_escrito_dni($_POST["dni"]))
                echo "<span class='error'>* Dni no está bien escrito*</span>";
            elseif(!valido_dni($_POST["dni"]))
                echo "<span class='error'>* DNI no válido *</span>";
            else
                echo "<span class='error'>* DNI repetido *</span>";
        }
    ?>
    </p>
    <p>
    <label>Sexo</label><br />
    <input type="radio" name="sexo" value="hombre" id="hombre" <?php if(!isset($_POST["sexo"]) || $_POST["sexo"]=="hombre") echo "checked";?>/>
    <label for="hombre">Hombre: </label> <br />
    
    <input type="radio" name="sexo" value="mujer" id="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";?>/>
    <label for="mujer">Mujer: </label>

    </p>
    <p>
    <label for="foto">Incluir mi foto (Max. 500KB)</label>
    <input type="file" name="foto" id="foto" accept="image/*"/>			
    <?php
    if(isset($_POST["btnContNuevo"])&& $error_foto)
    {
        if($_FILES["foto"]["error"])
            echo "<span class=''>* Error en la subida del fichero *</span>";
        elseif(!getimagesize($_FILES["foto"]["tmp_name"]))
            echo "<span class=''>* El fichero subido no es un archivo imagen *</span>";
        else
            echo "<span class=''>* El tamaño del fichero supera los 500KB *</span>";
    }

    ?>
    </p>
    <p>
    <input type="submit" value="Volver" />
    <input type="submit" value="Guardar Cambios" name="btnContNuevo" />
    
    </p>

</form>
