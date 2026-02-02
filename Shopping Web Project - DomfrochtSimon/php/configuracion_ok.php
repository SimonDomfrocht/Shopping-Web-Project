<?php

	session_start();

	if(!empty($_POST['tema']) && !empty($_SESSION['username'])){
		$usuario = $_SESSION['username'];
		$tema = $_POST['tema'];
		$tiempo_expira = time() + (30 * 24 * 60 * 60); 

		setcookie('tema_' . $usuario, $tema, $tiempo_expira, '/');

		header('refresh:0; url=articulo_listado.php');
	}else{
		echo '<p>The configuration could not be saved.</p>';
	}


?>