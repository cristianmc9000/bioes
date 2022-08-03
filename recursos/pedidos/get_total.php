<?php 
	require("../conexion.php");
	$id = $_GET['id'];

	$result = $conexion->query("SELECT total, total_cd FROM `pedidos` WHERE id = ".$id);
	$result = $result->fetch_all(MYSQLI_ASSOC);

	echo json_encode($result);


?>