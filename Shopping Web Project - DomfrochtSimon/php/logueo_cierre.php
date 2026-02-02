<?php
	session_start();
	include 'encabezado.php';
	if(!empty($_SESSION['username'])){
		
		echo '<h2>You are leaving the session</h2>';
		session_destroy();
		header('refresh:4; ../index.php');

	}else{
		header('refresh:3; ../index.php');
		echo '<h2>No login detected</h2>';
	}

	include 'pie.php';


?>