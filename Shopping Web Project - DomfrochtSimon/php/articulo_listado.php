<?php
	session_start();
    $ruta = '../';
    include'encabezado.php';
	
	require_once('conexion.php');
	if(!empty($_SESSION['username'])){
		//agregar el header
	
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
		
	}else{
		echo '<p>No inicio sesion</p>';
	}
	
	
	
?>


<main class="container">
    <section class="row">
        <form action="" method="" class="p-5 d-flex justify-content-start align-items-center">
            <label for="categoria" class="form-label me-3">Filter by category:</label>
            <select id="categoria" name="categoria" class="form-select w-25 me-3">
                <option value="">None</option>
                <option value="Phones">Phones</option>
                <option value="Household appliances">Household appliances</option>
                <option value="Televisions">Televisions</option>
            </select>
            <input type="text" name="busqueda" placeholder="Search..." class="form-control w-25 me-3">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </section>
    <section>
        <article class="row text-center">
            <section class="d-flex justify-content-center pt-3">
                <table class="table table-bordered table-hover table-striped w-auto">
                    <caption class="caption-top text-center bg-dark text-white">List of objects</caption>
                    <tr>
                        <th class="bg-secondary text-white">Photo</th>
                        <th class="bg-secondary text-white">Product</th>
                        <th class="bg-secondary text-white">Category</th>
                        <th class="bg-secondary text-white">Price</th>
						<?php 
							if($_SESSION['username'] == 'admin'){
								
								echo '<th class="bg-secondary text-white">Modify</th>
									<th class="bg-secondary text-white">Delete</th>';
							}else{
								echo '<th class="bg-secondary text-white">Add to Cart</th>';
							}
						
						?>
						
                    </tr>
					
					
                    
                    <?php
						$conexion = conectar();
						
						if(!empty($_GET['categoria'])) {
							$categoria = $_GET['categoria'];
						}else{
							$categoria = '';
						}

						if(!empty($_GET['busqueda'])) {
							$busqueda = $_GET['busqueda'];
						}else{
							$busqueda = '';
						}

						
						if ($categoria != '' && $busqueda != '') {
							
							$sql = 'SELECT id_articulo, nombre, categoria, precio, foto 
							FROM articulo 
							WHERE categoria = ? AND nombre LIKE ?';
							
							$busqueda = "%$busqueda%";
							$sentencia = mysqli_prepare($conexion, $sql);
							mysqli_stmt_bind_param($sentencia, 'ss', $categoria, $busqueda);
							
						}else if ($categoria != '') {
							
							$sql = 'SELECT id_articulo, nombre, categoria, precio, foto 
							FROM articulo 
							WHERE categoria = ?';
							
							$sentencia = mysqli_prepare($conexion, $sql);
							mysqli_stmt_bind_param($sentencia, 's', $categoria);
							
						}elseif ($busqueda != '') {
							$sql = 'SELECT id_articulo, nombre, categoria, precio, foto 
							FROM articulo 
							WHERE nombre LIKE ?';
							
							$busqueda = "%$busqueda%";
							$sentencia = mysqli_prepare($conexion, $sql);
							mysqli_stmt_bind_param($sentencia, 's', $busqueda);
							
						} else {
							$sql = 'SELECT id_articulo, nombre, categoria, precio, foto FROM articulo';
							$sentencia = mysqli_prepare($conexion, $sql);
						}

						mysqli_stmt_execute($sentencia);
						mysqli_stmt_bind_result($sentencia, $id, $nombre, $categoria, $precio, $foto);

						while (mysqli_stmt_fetch($sentencia)) {
							if ($foto == '') {
								$foto = 'sin_imagen.png';
							}
							
							if($_SESSION['username'] == 'admin'){
								
								echo '<tr>';
								echo '<td class="bg-secondary text-white"><img src="../img/articulos/' . $foto . '" width="80"></td>';
								echo '<td class="bg-secondary text-white">' . $nombre . '</td>';
								echo '<td class="bg-secondary text-white">' . $categoria . '</td>';
								echo '<td class="bg-secondary text-white">$' . number_format($precio, 0, ',', '.') . '</td>';
								
								echo '<td class="bg-secondary text-white"><a href="articulo_modificacion.php?id=' . $id . '"><img src="../img/modificar.png"></a></td>';
								echo '<td class="bg-secondary text-white"><a href="articulo_eliminar.php?id=' . $id . '"><img src="../img/eliminar.png"></a></td>';
								echo '</tr>';
								
								
								
							}else{
								
								echo '<tr>';
								echo '<td class="bg-secondary text-white"><img src="../img/articulos/' . $foto . '" width="80"></td>';
								echo '<td class="bg-secondary text-white">' . $nombre . '</td>';
								echo '<td class="bg-secondary text-white">' . $categoria . '</td>';
								echo '<td class="bg-secondary text-white">$' . number_format($precio, 0, ',', '.') . '</td>';
								
								echo '<td class="bg-secondary text-white"><a href="articulo_carrito.php?id=' . $id . '"><img src="../img/carrito.png"></a></td>';
								echo '</tr>';
							}
							
						}

						mysqli_close($conexion);
					?>
                </table>
            </section>
			<?php 
			
				if($_SESSION['username'] == 'admin'){
					
					echo '<nav>
							<form action="articulo_alta.php" class="d-flex flex-row justify-content-center p-4" method="post">
								<button type="submit" class="btn btn-primary">Add an object</button>
							</form>
						</nav>';
				}
			
			?>
        </article>
    </section>
</main>

<?php
    require("pie.php");
?>