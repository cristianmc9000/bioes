<?php
//Conectamos a la base de datos
require('../conexion.php');
$idPOST = $_POST['id'];

$caPOST = $_POST["ca"];
$ciPOST = $_POST["ci"];
$nombrePOST = $_POST["nombre"];
$apellidosPOST = $_POST["apellidos"];
$telefonoPOST = $_POST["telefono"];
$lugarPOST = $_POST["lugar"];
$correoPOST = $_POST["correo"];
$tipoPOST = $_POST["nivel"];
$fecha_alta = $_POST["fecha_alta_mod"];

$ca_ant = $_POST['ca_ant'];
$ci_ant = $_POST['ci_ant'];

// die('<script>Materialize.toast("'.$idPOST.'"); $("#modal3").closeModal();</script>');

if ($tipoPOST == '1') {
	$tipoPOST = 'experta';
}else{
	$tipoPOST = 'lider';
}

	if($ciPOST != $ci_ant){
		$consultaBuscarCi = "SELECT * FROM clientes WHERE CI= '".$ciPOST."'";
		$resultadoConsultaBCI = mysqli_query($conexion, $consultaBuscarCi) or die(mysql_error());
		$datosConsultaBCI = mysqli_fetch_array($resultadoConsultaBCI);
		if(isset($datosConsultaBCI['CI'])){
			die('<script>Materialize.toast("Ya existe un lider/experta con esa cédula de identidad.", 5000)</script>');
		}
	}

	if($caPOST != $ca_ant){
		$consultaBuscarCa = "SELECT * FROM clientes WHERE CA= '".$caPOST."'";
		$resultadoConsultaBCA = mysqli_query($conexion, $consultaBuscarCa) or die(mysql_error());
		$datosConsultaBCA = mysqli_fetch_array($resultadoConsultaBCA);
		if(isset($datosConsultaBCA['CA'])){
			die('<script>Materialize.toast("Ya existe un lider/experta con el código arbell.'.$caPOST.'", 5000)</script>');
		}
	}

	// die('<script>Materialize.toast("hasta aqui llega"); $("#modal3").closeModal();</script>');

	$consultaMC ="UPDATE clientes SET CA='".$caPOST."', CI='".$ciPOST."', nombre ='".strtoupper($nombrePOST)."', apellidos= '".strtoupper($apellidosPOST)."', telefono = '".$telefonoPOST."', lugar = '".$lugarPOST."', correo = '".$correoPOST."', nivel = '".$tipoPOST."', fecha_alta = '".$fecha_alta."' WHERE id='".$idPOST."'";

	if(mysqli_query($conexion, $consultaMC) or die(mysql_error())){
		die('success');
	}


?>