<?php
	function conectar() {
		$servidor = 'localhost';
		$usuario = 'root';
		$clave = '';
		$nombre = 'labo2';
		
		
		try {
			$conexion = mysqli_connect($servidor, $usuario, $clave, $nombre);
		}catch (Exception $e) {
			$conexion = false;
		}
		
		return ($conexion);
	}
	
	
	function desconectar ($miConexion) {
		if ($miConexion) {
			mysqli_close ($miConexion);
			echo '<p>Succesfully disconnected</p>';
		}
	}
?>