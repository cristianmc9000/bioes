<?php 
	require('../conexion.php');
	session_start();
	$ca = $_SESSION['ca'];
	$result = $conexion->query("SELECT * FROM pedidos WHERE ca = '".$ca."' AND estado = 1");
	$result = mysqli_num_rows($result);
	if ($result > 0) {
		die(true);
	}
	die(false);
?>