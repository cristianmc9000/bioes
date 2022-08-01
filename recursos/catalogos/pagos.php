<?php 
	require('../conexion.php');

	$cad = "";
	if (!empty($_GET['id'])) {
		$cad = "(SELECT b.codv FROM ventas b WHERE b.codp = ".$_GET['id'].")";
	}else{
		$cad = $_GET['codv'];
	}

	$result = $conexion->query("SELECT a.monto, a.fecha_pago FROM pagos a WHERE codv = ".$cad);
	$result = $result->fetch_all(MYSQLI_ASSOC);

	if ($result) {
		echo json_encode($result);
	}else{
		echo mysqli_error($conexion);
	}
?>