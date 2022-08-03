<?php 
	require("../conexion.php");

	$id = $_GET['id'];

	$result = $conexion->query("UPDATE `pedidos` SET `estado`='0' WHERE id = ".$id);

	echo $result;

?>