<?php 
	require('../conexion.php');
	$ca = $_GET['ca'];

	$result = $conexion->query('UPDATE `clientes` SET `block`= (IF(block = 1, 0, 1)) WHERE CA = "'.$ca.'"');
	
	if ($result) {
		$result2 = $conexion->query('SELECT block FROM clientes WHERE CA = "'.$ca.'"');
		if ($result2) {
			$res = $result2->fetch_all(MYSQLI_ASSOC);
			echo $res[0]['block'];
		}
	}
	
	echo mysqli_error($conexion);

?>


