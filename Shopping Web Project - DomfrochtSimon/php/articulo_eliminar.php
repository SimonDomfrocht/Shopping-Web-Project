<?php
	session_start();                          
	if (empty($_SESSION['username'])) {
		header('refresh:0; url=index.php');                                 
	}

	$ruta = '../';
	require 'encabezado.php';
	echo '<header class="container bg-primary p-3 d-flex align-items-center mb-4">
		<img src="../img/usuarios/' . $_SESSION['foto'] . '" 
			 alt="Foto usuario" width="60" 
			 class="me-3 rounded-circle border border-light">
		<h1 class="text-white">' . $_SESSION['username'] . '</h1>
		<nav class="d-flex flex-row align-items-center ms-auto">
            <form action="logueo_cierre.php" method="post" class="me-3 mb-0">
                <button type="submit" class="btn btn-danger">Log out</button>
            </form>
			<a href="configuracion.php" title="Configuración">
				<img src="../img/engranaje.png" alt="Configuración" width="35" class="filter-white">
			</a>
        </nav>
		</header>';

	require("conexion.php");
	$conexion = conectar();

	if ($conexion && !empty($_GET['id'])) {
		$id = $_GET['id'];
		$consulta = 'SELECT id_articulo, nombre, categoria, precio, foto
		FROM articulo
		WHERE id_articulo = ?';

		$sentencia = mysqli_prepare($conexion, $consulta);
		mysqli_stmt_bind_param($sentencia, 'i', $id);
		mysqli_stmt_execute($sentencia);
		mysqli_stmt_bind_result($sentencia, $id_articulo, $nombre, $categoria, $precio, $foto);
		
		if (mysqli_stmt_fetch($sentencia)) {
			echo '
			<main class="container text-center py-5">
				<h2>Object deletion</h2>
				<p>Are you sure you want to delete the object <strong>' . $nombre . '</strong>?</p>
				<a href="articulo_eliminar_ok.php?id_articulo=' . $id_articulo . '" class="btn btn-primary me-2">Accept</a>
				<a href="articulo_listado.php" class="btn btn-secondary">Cancel</a>
			</main>';
		} else {
			echo '<p>Object not found.</p>';
		}
	}
	
	$tema = 'oscuro';
	$usuario = $_SESSION['username'];
		
	if(!empty($_COOKIE['tema_' . $usuario])){
		$tema = $_COOKIE['tema_' . $usuario];
	}
			
	if($tema == 'claro'){
		echo '<body class="bg-light text-dark">';
	}else{
		echo '<body class="bg-dark text-white">';
	}
?>


<?php
    require("pie.php");
?>