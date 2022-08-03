<?php 
	require("../conexion.php");

	$valor = $_GET['valor'];
	$result = $conexion->query("UPDATE `cambio` SET `valor`='".$valor."' WHERE id = 2");

	echo $result;
?>