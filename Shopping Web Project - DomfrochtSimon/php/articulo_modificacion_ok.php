<?php
	
	require_once('conexion.php');
	$conexion = conectar();

	if($conexion && !empty($_POST['id_articulo']) && !empty($_POST['nombre']) && !empty($_POST['categoria']) && !empty($_POST['precio'])){
		
		$id = $_POST['id_articulo'];
		$nombre = $_POST['nombre'];
		$categoria = $_POST['categoria'];
		$precio = $_POST['precio'];
		
		if (!empty($_FILES['imagen']['name'])){
			$foto = $_FILES['imagen']['name'];
			move_uploaded_file($_FILES['imagen']['tmp_name'], '../img/articulos/' . $foto);
			
		}else{
			$foto = 'sin_imagen.png';
		}
		
		$consulta = 'UPDATE articulo
		SET nombre = ?, categoria = ?, precio = ?, foto = ?
		WHERE id_articulo = ?';
		
		$sentencia = mysqli_prepare($conexion,$consulta);
		mysqli_stmt_bind_param($sentencia,'ssdsi',$nombre,$categoria,$precio,$foto,$id);
		$estado = mysqli_stmt_execute($sentencia);
		if($estado){
			echo '<p>Modification successful</p>';
			header('refresh:3;url=articulo_listado.php');
		}else{
			echo '<p>Modification failed</p>';
		}
		
		desconectar($conexion);
	}else{
		echo '<p>Missing data</p>';
	}

?>