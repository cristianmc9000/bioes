<?php 
	require("../conexion.php");
	$codp = $_GET['codp'];
	$id = $_GET['id'];
	$estado = $_GET['estado'];

	$result = $conexion->query("UPDATE `detalle_pedido` SET `estado`='".$estado."' WHERE codped = ".$id." AND codpro = '".$codp."'");
	if ($result) {
		if ($estado == '0') {
			$res = $conexion->query("UPDATE pedidos a SET `total`=ROUND((total-(SELECT b.pubs*b.cant FROM detalle_pedido b WHERE b.codped = ".$id." AND b.codpro = '".$codp."')),1),`total_cd`=ROUND((total_cd-(SELECT c.pubs_cd*c.cant FROM detalle_pedido c WHERE c.codped = ".$id." AND c.codpro = '".$codp."')),1) WHERE a.id = ".$id."");
		}else{
			$res = $conexion->query("UPDATE pedidos a SET `total`=ROUND((total+(SELECT b.pubs*b.cant FROM detalle_pedido b WHERE b.codped = ".$id." AND b.codpro = '".$codp."')),1),`total_cd`=ROUND((total_cd+(SELECT c.pubs_cd*c.cant FROM detalle_pedido c WHERE c.codped = ".$id." AND c.codpro = '".$codp."')),1) WHERE a.id = ".$id."");
		}

		echo $result,$res;
	}else{
		echo mysqli_error($conexion);
	}
?>