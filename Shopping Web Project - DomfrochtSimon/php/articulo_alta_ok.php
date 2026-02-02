<?php

	if(!empty($_POST['nombre']) && !empty($_POST['categoria']) && !empty($_POST['precio']) && !empty($_FILES['imagen']['size'])){
		
		require_once('conexion.php');
		$conexion = conectar();
		
		if($conexion){
			$nombrePro = $_POST['nombre'];
			$catPro = $_POST['categoria'];
			$precioPro = $_POST['precio'];
			
			$imgPro = $_FILES['imagen']['name'];
			$imgTmp = $_FILES['imagen']['tmp_name'];
			$rutaDestino = '../img/articulos/' . $imgPro;
			move_uploaded_file($imgTmp, $rutaDestino);
			
			$consulta = 'INSERT INTO articulo(nombre,categoria,precio,foto)
			VALUES (?,?,?,?)';
			$sentencia = mysqli_prepare($conexion,$consulta);
			mysqli_stmt_bind_param($sentencia, 'ssds', $nombrePro, $catPro, $precioPro,$imgPro);
			$q = mysqli_stmt_execute($sentencia);
			
			if($q){
				echo '<p>Saved successfully.</p>';
				header('refresh:3;url=articulo_listado.php');
			}else{
				echo '<p>Failed to save.</p>';
			}
			
			desconectar($conexion);
		}
		
		
	}else{
		echo '<p>Some fields are missing.</p>';
	}

?>