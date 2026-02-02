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
            <form class="p-4 border rounded w-50" action="articulo_alta_ok.php" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend class="text-center mb-4">Add object</legend>

                    <label for="nombre" class="form-label">Object Name</label>
                    <input type="text" id="nombre" name="nombre" class="form-control mb-3" required>

                    <label for="categoria" class="form-label">Category</label>
                    <input type="text" id="categoria" name="categoria" class="form-control mb-3" required>

                    <label for="precio" class="form-label">Price</label>
                    <input type="number" step="0.01" id="precio" name="precio" class="form-control mb-3" required>

                    <label for="imagen" class="form-label">Object Image</label>
                    <input type="file" id="imagen" name="imagen" class="form-control mb-4" required>

                    <button type="submit" class="btn btn-primary w-100">Add object</button>
                </fieldset>
            </form>
        </section>
    </main>

<?php
    require("pie.php");
?>