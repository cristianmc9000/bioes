<?php 
require("../conexion.php");
$codc = $_GET['codc'];
$codp = $_GET['codp'];
$cant = $_GET['cant'];


// $result = $conexion->query("SELECT a.cantidad FROM inventario a WHERE a.codp = '".$codp."' ORDER BY a.id DESC LIMIT 1");
// $cantidad = $result->fetch_assoc();
// $cantidad['cantidad']; //<---cantidad de datos del producto
	
	$result = $conexion->query("SELECT cantidad FROM invcant WHERE codp = '".$codp."'");
	$cantidad = $result->fetch_assoc();
	$cant_invcant = $cantidad['cantidad'];

	if ($cant_invcant < $cant) {
		die("0");
	}
	//Reduciendo cantidad de la tabla: invcant
	$conexion->query("UPDATE invcant SET cantidad = cantidad-".$cant." WHERE codp = '".$codp."' ");	

	//Eliminar de la tabla detalle_compra
	$conexion->query("UPDATE detalle_compra SET estado = 0 WHERE codc = ".$codc." AND codp = '".$codp."'");

	//Reduciendo el monto pagado de la compra
	$conexion->query("UPDATE compras SET totalsd = totalsd - (SELECT (pubs*cantidad) as resultado FROM detalle_compra WHERE codc = ".$codc." AND codp = '".$codp."'), totalcd = totalcd - (SELECT (pubs_cd*cantidad) as resultado FROM detalle_compra WHERE codc = ".$codc." AND codp = '".$codp."') WHERE codc = ".$codc." ");
	//eliminando compra si el monto pagado llega a 0
	$res = $conexion->query("SELECT COUNT(a.codp) as cant FROM detalle_compra a WHERE a.codc = ".$codc." AND a.estado = 1");
	$res = $res->fetch_assoc();
	if ($res['cant'] < 1) {
		$conexion->query("UPDATE compras SET estado = 0 WHERE codc = ".$codc);
	}
	//reducir cantidad de tabla: inventario
	while($cant>0){
		$result = $conexion->query("SELECT a.cantidad, a.id FROM inventario a WHERE a.codp = '".$codp."' AND a.estado = 1 ORDER BY a.id DESC LIMIT 1");
		$cantidad = $result->fetch_assoc();
		$cant_inv = $cantidad['cantidad']; //<---cantidad de datos del producto
		$id_inv = $cantidad['id'];

		if($cant_inv <= $cant){
			$conexion->query("UPDATE inventario SET cantidad = 0, estado = 0 WHERE id = ".$id_inv);
			$cant = $cant - $cant_inv;
		}else{
			$conexion->query("UPDATE inventario SET cantidad = cantidad - ".$cant." WHERE id = ".$id_inv);
			$cant = 0;
		}
	}




echo mysqli_error($conexion);



?>