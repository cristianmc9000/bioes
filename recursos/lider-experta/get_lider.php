<?php 
	require('../conexion.php');

	$id = $_GET['id'];
	$result = $conexion->query('SELECT * FROM clientes WHERE CA = '.$id);

	if ($result) {
		$res = $result->fetch_all(MYSQLI_ASSOC);
		echo $res[0]['nombre'].' '.$res[0]['apellidos'];
	}else{
		echo 'nodata';
	}

?>