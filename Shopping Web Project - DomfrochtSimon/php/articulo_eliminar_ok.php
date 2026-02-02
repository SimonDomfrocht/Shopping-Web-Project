<?php
	require_once('conexion.php');
	$conexion = conectar();

	if ($conexion && !empty($_GET['id_articulo'])) {
		$id = $_GET['id_articulo'];

		$consulta = 'DELETE FROM articulo WHERE id_articulo = ?';
		$sentencia = mysqli_prepare($conexion, $consulta);
		mysqli_stmt_bind_param($sentencia, 'i', $id);
		$estado = mysqli_stmt_execute($sentencia);

		if ($estado) {
			echo '<p>Deletion successful.</p>';
			header('refresh:3;url=articulo_listado.php');
		} else {
			echo '<p>Error during deletion.</p>';
		}
		
		desconectar($conexion);
	} else {
		echo '<p>The deletion was not performed (missing data).</p>';
	}

?>