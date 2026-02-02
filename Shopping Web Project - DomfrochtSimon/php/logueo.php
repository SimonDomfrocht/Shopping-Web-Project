<?php
	session_start();

	require_once('conexion.php');
	$conexion = conectar();

	if($conexion) {
		if(!empty($_POST['username']) && !empty($_POST['password'])){

			$usu = $_POST['username'];
			$pass = sha1($_POST['password']); 

			$consulta = 'SELECT usuario, foto FROM usuario WHERE usuario = ? AND pass = ?';
			$sentencia = mysqli_prepare($conexion, $consulta);
			mysqli_stmt_bind_param($sentencia, 'ss', $usu, $pass);
			mysqli_stmt_execute($sentencia);
			mysqli_stmt_bind_result($sentencia, $usuario, $foto);
			mysqli_stmt_store_result($sentencia);
			
			$cantFilas = mysqli_stmt_num_rows($sentencia);
			
			if($cantFilas == 1){
				mysqli_stmt_fetch($sentencia);
				
				$_SESSION['username'] = $usuario;
				$_SESSION['foto'] = ($foto != '') ? $foto : 'usuario_default.png';

				echo '<h2>Login successful</h2>';
				header('refresh:3; url=articulo_listado.php');
			}else{
				echo '<p>User or password incorrect</p>';
			}
		}else {
			echo '<p>Data missing</p>';
		}

		desconectar($conexion);
	}else {
		echo '<p>Connection error</p>';
	}
?>