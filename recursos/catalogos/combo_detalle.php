<?php 
	require("../conexion.php");
	
	$id = $_GET['cp'];
	$result = $conexion->query('SELECT a.id_combo, MIN(b.cantidad) as cantidad FROM combo a, invcant b WHERE id_combo = "'.$id.'" AND b.codp = a.id_prod');

	$res = $result->fetch_all(MYSQLI_ASSOC);
	echo $res[0]['cantidad'];

?>