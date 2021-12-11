<?php 
	require('../conexion.php');
	$id = $_GET['id'];

	$res = $conexion->query("UPDATE `productos` SET `estado`= 1 WHERE id = ".$id);
	if ($res) {
		echo '1';
	}else{
		echo mysqli_error($conexion);
	}

?>