<?php 
	require("../conexion.php");
	
	$id = $_GET['id'];
	$result = $conexion->query('SELECT checkbox FROM productos WHERE id = "'.$id.'"');
	$res = $result->fetch_all(MYSQLI_ASSOC);

	echo $res[0]['checkbox'];

?>