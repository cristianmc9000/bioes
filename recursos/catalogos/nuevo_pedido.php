<?php 
	require("sesiones.php");
	require("../conexion.php");
	session_start();

	date_default_timezone_set("America/La_Paz");
	$fecha = date("Y-m-d H:i:s");

	$cambio = $conexion->query("SELECT valor FROM cambio WHERE id = 2");
	$cambio = $cambio->fetch_all();

	$ca = "";
	if (isset($_GET['ca_exp'])) {
		$ca = $_GET['ca_exp'];
	}else{
		$ca = $_SESSION['ca'];
	}

	// $per = $_SESSION['periodox'];

	$res3 = $conexion->query('SELECT block FROM clientes WHERE CA = "'.$ca.'"');
	$res3 = $res3->fetch_all(MYSQLI_ASSOC);
	if ($res3[0]['block'] == '0') {
		die('block');
	}

	$result = $conexion->query("SELECT * FROM pedidos WHERE ca = '".$ca."' AND estado = 1");
	$result = mysqli_num_rows($result);
	if ($result > 0) {
		die('2');
	}


	$total = $_GET['total'];
	$total_cd = $_GET['total_cd'];
	$a = json_decode($_GET['a']);
	$cred = $_GET['cred'];

	$desc = ((float)$_SESSION['desc'])*100;
	$result = $conexion->query("INSERT INTO pedidos (ca, fecha, total, total_cd, valor_peso, credito) VALUES('".$ca."', '".$fecha."',".$total.", ".$total_cd.", ".$cambio[0][0].", ".$cred.")");

	$lastid = mysqli_insert_id($conexion);

	if($cred == "true"){
		$cred = 1;
	}else{
		$cred = 0;
	}
	$dato = "";

				// cp, np, cantp, pp, pub, pup, codli, checkbox
	$id_desc = 0;
	if ($desc == 30) {
		$id_desc = 2;
	}

	$pubs_cd = 0;
	foreach($a as $x){
		// $dato = $dato."--".$x[0];
		// die($x[0]."--".$x[1]."--".$x[2]."--".$x[3]."--".$x[4]."--".$x[5]."--".$x[6]."--".$x[7]);
		if ($x[6] == 11 || $x[7] == 1) {
			$pubs_cd = $x[4];
		}else{
			$pubs_cd = round((((float)($x[4]))-(((float)($x[4]))*((float)$_SESSION['desc']))), 1);
		}

		$result = $conexion->query("INSERT INTO `detalle_pedido`(`codped`, `codpro`, `cant`, `descuento`, `pubs`, `pubs_cd`) VALUES (".$lastid.",'".$x[0]."',".$x[2].", ".$id_desc.", '".$x[4]."','".$pubs_cd."')");
	}

	// die(mysqli_error($conexion));
	echo $result;
?>