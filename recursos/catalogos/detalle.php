<?php 
	require('../conexion.php');
	
	$result;
	$cad = '';
	if (!empty($_GET['id'])) {
		$result = $conexion->query("SELECT a.codpro, a.cant, b.descripcion, a.pubs_cd FROM detalle_pedido a, productos b WHERE a.codpro = b.id AND a.codped = ".$_GET['id']);
	}else{
		$result = $conexion->query("SELECT a.codp as codpro, a.cantidad as cant, b.descripcion, a.pubs_cd FROM detalle_venta a, productos b WHERE a.codp = b.id AND a.codv = ".$_GET['codv']);
	}

	if ($result) {
		$result = $result->fetch_all(MYSQLI_ASSOC);
		echo json_encode($result);
	}else{
		echo mysqli_error($conexion);
	}

?>