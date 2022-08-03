<?php 
require("../conexion.php");

$id = $_GET['id'];
//consulta para traer el detalle del pedido para la tabla de aceptar pedido
$result = $conexion->query("SELECT a.codpro as id, a.cant as cantidad, a.pubs, a.pubs_cd as pubs_desc, c.codli, c.nombre as linea, b.descripcion, a.codped, a.estado FROM detalle_pedido a, productos b, lineas c WHERE b.linea = c.codli AND a.codpro = b.id AND a.codped = ".$id);

$res = $result->fetch_all(MYSQLI_ASSOC);

if ($result) {
	if (isset($_GET['x'])) {
		//Consulta para aceptar el pedido, retorna el detalle del pedido sin los productos con estado = 0
		$result = $conexion->query("SELECT a.codpro as id, a.cant as cantidad, a.pubs, a.pubs_cd as pubs_desc, c.codli, c.nombre as linea, b.descripcion, a.descuento, b.combo, a.codped  FROM detalle_pedido a, productos b, lineas c WHERE b.linea = c.codli AND a.estado = 1 AND a.codpro = b.id AND a.codped = ".$id);
		if (($result->num_rows) < 1) {
			die("nodata");
		}else{
			$res = $result->fetch_all(MYSQLI_ASSOC);
		}
		
		$status = $conexion->query("UPDATE `pedidos` SET `estado`='2' WHERE id = ".$id);
	}
	echo json_encode($res);
}else{
	echo mysqli_error($conexion);
}

?>

