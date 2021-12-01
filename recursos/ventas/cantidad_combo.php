<?php 
	require("../conexion.php");
	$menor = 100;
	if (sizeof($array_combo)>0) {
		foreach ($array_combo as $arr){ 
			$result = $conexion->query("SELECT codp, cantidad FROM `invcant` WHERE codp = '".$arr['id']."' AND estado = 1");
			$result = $result->fetch_array(MYSQLI_ASSOC);

			if ($result['cantidad'] < $menor) {
				$menor = $result['cantidad'];
			}
		}

		if ($menor < 1) {
			die('3');
		}else{
			die("hola");
		}
	}else{
		die("no entro al if");
	}

?>