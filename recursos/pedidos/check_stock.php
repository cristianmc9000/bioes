<?php 
	require("../conexion.php");

	$id = $_GET['id'];

	$result = $conexion->query("SELECT a.codpro as id, a.cant as cantidad,(SELECT d.cantidad FROM  invcant d WHERE d.codp = a.codpro) AS stock, b.descripcion, b.combo FROM detalle_pedido a, productos b WHERE a.estado = 1 AND a.codpro = b.id AND a.codped = ".$id);
	$res = $result->fetch_all(MYSQLI_ASSOC);



	$item = array();
	foreach ($res as $key => $value) {

		if ($value['combo'] == '1') {
			$result2 = $conexion->query('SELECT MIN(c.cantidad) as cant FROM combo a, productos b, invcant c WHERE a.id_prod = c.codp AND a.id_combo = b.id AND a.id_combo = "'.$value['id'].'"');
			$result2 = $result2->fetch_all(MYSQLI_ASSOC);
			$res[$key]['stock'] = $result2[0]['cant'];
		}

		if ($res[$key]['cantidad'] > $res[$key]['stock']) {
			$item = array("codpro" => $res[$key]['id'], "desc" => $res[$key]['descripcion'], "stock" => $res[$key]['stock']);
			die(json_encode($item));
		}
	}

	echo '1';


?>