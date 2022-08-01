<?php 
	require("../conexion.php");
	// date_default_timezone_set("America/La_Paz");
	// $fecha = date("Y-m-d");
	$id = $_GET['id'];

	$result = $conexion->query("SELECT IF (SUM(a.Cantidad)>0, SUM(a.Cantidad),0) as cantidad FROM inventario a WHERE a.estado = 1 AND a.codp = '".$id."'");
	$result = $result->fetch_all();

	echo $result[0][0];

?>