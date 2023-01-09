<?php
	require "src/bd_config.php";
	require "src/funciones.php";
	session_name("pag_curso22_23");
	session_start();
	
	function salto_POST($action,$name)
	{
		echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'/><title>No importa</title></head>";
		echo "<body onload='document.getElementById(\"form_salto\").submit();'>";
		echo "<form id='form_salto' action='".$action."' method='post'>";
		echo "<input type='hidden' name='".$name."' value='ok'/>";
		echo "</form>";
		echo"</body></html>";
	
	}
	
	
	
	if(isset($_POST["btnVolver"]))
	{
		header("Location:index.php");
		exit();
	}

	if(isset($_POST["btnContinuar"]))
	{
		
		$error_nombre=$_POST["nombre"]=="";
		$error_usuario=$_POST["usuario"]=="";
		$error_clave=$_POST["clave"]=="";
		$error_email=$_POST["email"]==""|| !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
		
		if(!$error_usuario||!$error_email)
		{
			try
			{
				$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
				mysqli_set_charset($conexion,"utf8");
				
			}
			catch(Exception $e)
			{
				die(pag_error("Práctica 1º CRUD","Nuevo Usuario","Imposible conectar. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error())); 
			}
			
			if(!$error_usuario)
			{
				$error_usuario=repetido($conexion, "usuarios","usuario",$_POST["usuario"]);
			
				if(is_string($error_usuario))
				{
						mysqli_close($conexion);
						die(pag_error("Práctica 1º CRUD","Nuevo Usuario",$error_usuario)); 
				}
			}
			if(!$error_email)
			{
				$error_email=repetido($conexion, "usuarios","email",$_POST["email"]);
				
				if(is_string($error_email))
				{
					mysqli_close($conexion);
					die(pag_error("Práctica 1º CRUD","Nuevo Usuario",$error_email)); 
				}
			}	
		}	

		$error_form=$error_nombre||$error_usuario||$error_clave||$error_email;

		if(!$error_form)
		{
	
			$consulta="insert into usuarios(nombre,usuario,clave,email) values ('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".$_POST["email"]."')";
			try
			{
				mysqli_query($conexion,$consulta);
				mysqli_close($conexion);
				salto_POST("index.php","usuario_nuevo");
				$_SESSION["buscar"]=$_POST["nombre"];
				$_SESSION["pag"]=1;
				exit();
	
			}	
			catch(Exception $e)
			{
				$mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
				mysqli_close($conexion);
				die(pag_error("Práctica 1º CRUD","Nuevo Usuario",$consulta)); 
			}
		}
		
	}
	
	
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Práctica 1º CRUD</title>
	</head>
	<body>
		<h1>Nuevo Usuario</h1>
		<form action="usuario_nuevo.php" method="post">
			<p>
				<label for="nombre">Nombre:</label>
				<input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>" maxlength="30"/>
				<?php
				if(isset($_POST["nombre"]) && $error_nombre)
					echo "<span class='error'> Campo vacío </span>";
				?>
			</p>
			<p>
				<label for="usuario">Usuario:</label>
				<input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>" maxlength="20"/>
				<?php
				if(isset($_POST["usuario"]) && $error_usuario)
					if($_POST["usuario"]=="")
						echo "<span class='error'> Campo vacío </span>";
					else
						echo "<span class='error'> Usuario repetido </span>";
				?>
			</p>
			<p>
				<label for="clave">Contraseña:</label>
				<input type="password" name="clave" id="clave" value="" maxlength="20"/>
				<?php
				if(isset($_POST["clave"]) && $error_clave)
					echo "<span class='error'> Campo vacío </span>";
				?>
			</p>
			<p>
				<label for="email">E-mail:</label>
				<input type="text" name="email" id="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"];?>" maxlength="50"/>
				<?php
				if(isset($_POST["email"]) && $error_email)
				{
					if($_POST["email"]=="")
						echo "<span class='error'> Campo vacío </span>";
					elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
						echo "<span class='error'> Email sintácticamente incorrecto </span>";
					else
						echo "<span class='error'> Email repetido </span>";
				}
				?>
			</p>
			<p>
				<button type="submit" name="btnVolver">Volver</button>
				<button type="submit" name="btnContinuar">Continuar</button>
			</p>
		</form>
	</body>
</html>
