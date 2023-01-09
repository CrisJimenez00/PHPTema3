<?php
	require "src/bd_config.php";
	require "src/funciones.php";

	session_name("pag_curso22_23");
	session_start();


	if(isset($_POST["usuario_nuevo"]))
		$mensaje_accion="Usuario registrado con éxito";


	if(isset($_POST["btnContinuarEditar"]))
	{	

		$error_nombre=$_POST["nombre"]=="";
		$error_usuario=$_POST["usuario"]=="";
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
				$error_usuario=repetido($conexion, "usuarios","usuario",$_POST["usuario"],"id_usuario",$_POST["btnContinuarEditar"]);
			
				if(is_string($error_usuario))
				{
						mysqli_close($conexion);
						die(pag_error("Práctica 1º CRUD","Nuevo Usuario",$error_usuario)); 
				}
			}
			if(!$error_email)
			{
				$error_email=repetido($conexion, "usuarios","email",$_POST["email"],"id_usuario",$_POST["btnContinuarEditar"]);
				
				if(is_string($error_email))
				{
					mysqli_close($conexion);
					die(pag_error("Práctica 1º CRUD","Nuevo Usuario",$error_email)); 
				}
			}	
		}

		
		$error_form_editar=$error_nombre||$error_usuario||$error_email;
		if(!$error_form_editar)
		{
			
			if($_POST["clave"]=="")
				$consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', email='".$_POST["email"]."' where id_usuario='".$_POST["btnContinuarEditar"]."'";
			else
				$consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', clave='".md5($_POST["clave"])."', email='".$_POST["email"]."' where id_usuario='".$_POST["btnContinuarEditar"]."'";
			try
			{
					mysqli_query($conexion,$consulta);
					$mensaje_accion="Usuario editado con Éxito";

			}
			catch(Exception $e)
			{
				$mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
				mysqli_close($conexion);
				die(pag_error("Práctica 1º CRUD","Listado de los usuarios",$mensaje)); 
			}
		}

	}

	if(isset($_POST["btnContinuarBorrar"]))
	{
		try
		{
			$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
			mysqli_set_charset($conexion,"utf8");
		
		}
		catch(Exception $e)
		{
			die(pag_error("Práctica 1º CRUD","Listado de los usuarios","Imposible conectar. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error())); 
		}
		
		$consulta="delete from usuarios where id_usuario='".$_POST["btnContinuarBorrar"]."'";
		try
		{
				$resultado=mysqli_query($conexion,$consulta);
				$mensaje_accion="Usuario borrado con Éxito";
				$_SESSION["pag"]=1;

		}
		catch(Exception $e)
		{
			$mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
			mysqli_close($conexion);
			die(pag_error("Práctica 1º CRUD","Listado de los usuarios",$mensaje)); 
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Práctica 1º CRUD</title>
		<style>
			table,th,td{border:1px solid black;}
			table{border-collapse:collapse}
			td img{height:75px}
			.txt_centrado{ text-align:center;}
			.centrar{width:80%;margin:1em auto;}
			.enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
			.flexible{display:flex;justify-content:space-between}
		</style>
	</head>
	<body>
		<h1 class='txt_centrado'>Listado de los usuarios</h1>
		<?php
			if(!isset($conexion))
			{
				try
				{
					$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
					mysqli_set_charset($conexion,"utf8");
				}
				catch(Exception $e)
				{
					die("<p>Imposible conectar. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error()."</p>"); 
				}
			}
			
			require "vistas/vista_tabla_principal.php";

			if(isset($mensaje_accion))
					echo "<p class='centrar'>".$mensaje_accion."</p>";


			if(isset($_POST["btnListar"]))
			{
				require "vistas/vista_listar.php";
			}
			elseif(isset($_POST["btnBorrar"]))
			{
				require "vistas/vista_borrar.php";
			}
			elseif(isset($_POST["btnEditar"]) || (isset($_POST["btnContinuarEditar"])&& $error_form_editar))
			{
				require "vistas/vista_editar.php";
			}
			else
			{
				require "vistas/vista_boton_nuevo.php";
			}

			mysqli_close($conexion);
		?>
	</body>
</html>
