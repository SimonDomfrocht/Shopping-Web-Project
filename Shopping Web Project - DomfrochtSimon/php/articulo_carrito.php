<?php
	
	session_start();                          
	if (empty($_SESSION['username'])) {
		header('refresh:0; url=index.php');                                 
	}

	$ruta = '../';
	require_once('encabezado.php');
	
	echo '<header class="container bg-primary p-3 d-flex align-items-center mb-4">
		<img src="../img/usuarios/' . $_SESSION['foto'] . '" 
			 alt="Foto usuario" width="60" 
			 class="me-3 rounded-circle border border-light">
		<h1 class="text-white">' . $_SESSION['username'] . '</h1>
		<nav class="d-flex flex-row align-items-center ms-auto">
            <form action="logueo_cierre.php" method="post" class="me-3 mb-0">
                <button type="submit" class="btn btn-danger">Cerrar sesión</button>
            </form>
			<a href="configuracion.php" title="Configuración">
				<img src="../img/engranaje.png" alt="Configuración" width="35" class="filter-white">
			</a>
        </nav>
		</header>';
		
	require("conexion.php");
	$conexion = conectar();

	if(empty($_SESSION['carrito'])) {
		$_SESSION['carrito'] = array();
	}
	
	if(!empty($_GET['id'])) {
		
		$id = $_GET['id'];
		if(empty($_SESSION['carrito'][$id])) {
			$_SESSION['carrito'][$id] = 1;
		}else{
			$_SESSION['carrito'][$id]++;
		}
		echo '<h3 class="alert alert-success text-center">Object added to cart</h3>';
	}
	
	echo '<header class="bg-dark p-3 mb-4">
		<section class="container d-flex justify-content-between align-items-center">
			<h2 class="text-white h4 mb-0">Carrito de compras</h2>
			<a href="articulo_listado.php" class="btn btn-light">Back to the menu</a>
		</section>
	</header>';


	if(!empty($_SESSION['carrito'])) {

		echo '<main class="container">
            <section class="row justify-content-center text-center">
                <article class="col-auto">
                    <h4 class="mb-3">Your cart contains:</h4>
                    <table class="table table-bordered table-hover table-striped align-middle" style="width:80%; margin:0 auto;">
                        <thead>
                            <tr>
                                <th class="bg-secondary text-white">Product</th>
                                <th class="bg-secondary text-white">Category</th>
                                <th class="bg-secondary text-white">Photo</th>
                                <th class="bg-secondary text-white">Unit Price</th>
                                <th class="bg-secondary text-white">Quantity</th>
                                <th class="bg-secondary text-white">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>';

		$total = 0;

		foreach ($_SESSION['carrito'] as $id_articulo => $cant) {
			$sql = 'SELECT nombre, categoria, precio, foto FROM articulo WHERE id_articulo = ?';
			$sentencia = mysqli_prepare($conexion, $sql);
			mysqli_stmt_bind_param($sentencia, 'i', $id_articulo);
			mysqli_stmt_execute($sentencia);
			mysqli_stmt_bind_result($sentencia, $nombre, $categoria, $precio, $foto);
			mysqli_stmt_fetch($sentencia);

			if ($foto == '') {
				$foto = 'sin_imagen.png';
			}

			$subtotal = $precio * $cant;
			$total += $subtotal;

			echo '<tr>
					<td>' . $nombre . '</td>
					<td>' . $categoria . '</td>
					<td><img src="../img/articulos/' . $foto . '" width="80" alt="' . $nombre . '"></td>
					<td>$ ' . number_format($precio, 2, ',', '.') . '</td>
					<td>' . $cant . '</td>
					<td>$ ' . number_format($subtotal, 2, ',', '.') . '</td>
			</tr>';
			
			mysqli_stmt_close($sentencia);
		}

		echo '<tr>
				<td colspan="5" class="text-end fw-bold">Total</td>
				<td class="fw-bold">$ ' . number_format($total, 2, ',', '.') . ' USD</td>
			  </tr>';

		echo '</tbody></table></article></section></main>';
		
		$usuario = $_SESSION['username'];
		
		if(!empty($_COOKIE['tema_' . $usuario])){
			$tema = $_COOKIE['tema_' . $usuario];
		}
		
		if($tema == 'claro'){
			echo '<body class="bg-light text-dark">';
		}else{
			echo '<body class="bg-dark text-white">';
		}
		
	}else {
		echo '<p class="text-center">The cart is empty.</p>';
	}

	require_once('pie.php');
?>
