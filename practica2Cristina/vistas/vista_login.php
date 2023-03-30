<form action="index.php" method="post">
    <!--Usuario-->
    <p> <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" value="<?php
        if (isset($_POST["usuario"])) {
            echo $_POST["usuario"];
        }
        ?>">
        <?php
        if (isset($_POST["btnEnviar"]) && $error_usuario) {
            echo "*Debes rellenar el usuario*";
        }
        ?>
    </p>
    <!--Contraseña-->
    <p> <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave" value=<?php
        if (isset($_POST["clave"]))
            echo $_POST["clave"];
        ?>>
        <?php
        if (isset($_POST["btnEnviar"]) && $error_clave) {
            echo "*Debes rellenar la contraseña*";
        }
        ?>
    </p>

    <p>
        <!--Botones-->
        <button type="submit" name="btnEnviar">Entrar</button>
        <button type="submit" name="btnRegistrar">Registrarse</button>
    </p>
</form>