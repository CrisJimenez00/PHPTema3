<?php
	if(isset($_POST["btnSubir"]))
	{
		$error_archivo=$_FILES["foto"]["name"]==""||$_FILES["foto"]["error"]||!getimagesize($_FILES["foto"]["tmp_name"])||$_FILES["foto"]["size"]>500*1000;
	}	

?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Teoría Subir Archivos</title>
		<meta charset="UTF-8"/>
	</head>
	<body>
		<h1>Subir Archivos</h1>
		<form action="index.php" method="post" enctype="multipart/form-data">
			<p>
				<label for="foto">Seleccione un archivo imagen inferior a 500KB</label>
				<input type="file" name="foto" id="foto" accept="image/*"/>
				<?php
				if(isset($_POST["btnSubir"]) && $error_archivo)	
				{
					if($_FILES["foto"]["name"]!="")
					{
						if($_FILES["foto"]["error"])
							echo "<span class='error'>Error en la subida del archivo</span>";
						elseif(!getimagesize($_FILES["foto"]["tmp_name"]))
							echo "<span class='error'>Error no has seleccionado un archivo imagen</span>";
						else
							echo "<span class='error'>Error el tamaño de la imagen seleccionada supera los 500KB </span>";
					}	
					
				}
				?>
			</p>
			<p>
				<button type="submit" name="btnSubir">Subir Imagen</button>
			</p>
		</form>
		<?php
			if(isset($_POST["btnSubir"]) && !$error_archivo)
			{
				echo "<h1>Respuestas cuando ya no hay errores y la imagen se ha subido</h1>";
				echo "<p><strong>Nombre de la imagen seleccionada: </strong>".$_FILES["foto"]["name"]."</p>";	
				echo "<p><strong>Error en la subida: </strong>".$_FILES["foto"]["error"]."</p>";
				echo "<p><strong>Ruta del archivo temporal: </strong>".$_FILES["foto"]["tmp_name"]."</p>";
				echo "<p><strong>Tamaño del archivo: </strong>".$_FILES["foto"]["size"]." B</p>";
				echo "<p><strong>Tipo de archivo: </strong>".$_FILES["foto"]["type"]."</p>";
				
				$array_nombre=explode(".",$_FILES["foto"]["name"]);
				$extension="";
				if(count($array_nombre)>1)
					$extension=".".strtolower(end($array_nombre));
					
				$nombre_unico="img_".md5(uniqid(uniqid(),true));
				
				$nombre_nuevo_archivo=$nombre_unico.$extension;
				
				@$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"images/".$nombre_nuevo_archivo);
				if(!$var)
				{
					echo "<p>La imagen no ha podido ser movida por falta de permisos</p>";
				}
				else
				{
					echo "<h3>La imagen ha sido subida con éxito</h3>";
					echo "<img height='200' src='images/".$nombre_nuevo_archivo."'/>";
				}
			}	
				
		?>
	</body>
</html>
