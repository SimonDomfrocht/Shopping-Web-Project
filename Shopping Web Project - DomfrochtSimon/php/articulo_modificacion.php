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
	
	if($conexion && !empty($_GET['id'])){
		$id = $_GET['id'];
		$consulta = 'SELECT id_articulo, nombre, categoria, precio, foto
		FROM articulo
		WHERE id_articulo = ?';
		
		$sentencia = mysqli_prepare($conexion,$consulta);
		mysqli_stmt_bind_param($sentencia, 's', $id);
		mysqli_stmt_execute($sentencia);
		mysqli_stmt_bind_result($sentencia,$id,$nombre,$categoria,$precio,$foto);
		mysqli_stmt_store_result($sentencia);
		$cantFilas = mysqli_stmt_num_rows($sentencia);
		if($cantFilas > 0){
			mysqli_stmt_fetch($sentencia);
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

<main class="container py-3">
        <section class="d-flex justify-content-center">
            <form class="p-4 border rounded w-50" action="articulo_modificacion_ok.php" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend class="text-center mb-4">Object Modification</legend>

                    <input type="hidden" name="id_articulo" value="<?php echo $id ?>">

                    <label for="nombre" class="form-label">Object Name</label>
                    <input type="text" id="nombre" name="nombre" class="form-control mb-3" required value="<?php echo $nombre ?>">

                    <label for="categoria" class="form-label">Category</label>
                    <input type="text" id="categoria" name="categoria" class="form-control mb-3" required value="<?php echo $categoria ?>">

                    <label for="precio" class="form-label">Price</label>
                    <input type="number" step="0.01" id="precio" name="precio" class="form-control mb-3" required value="<?php echo $precio ?>">

                    <label for="imagen" class="form-label">Upload object image</label>
                    <input type="file" id="imagen" name="imagen" class="form-control mb-4" value="<?php echo $foto ?>">

                    <button type="submit" class="btn btn-primary w-100">Modify</button>
                </fieldset>
            </form>
        </section>
    </main>

<?php
    require("pie.php");
?>