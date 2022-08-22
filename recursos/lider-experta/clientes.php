<?php
//Conectamos a la base de datos
require('../conexion.php');
// date_default_timezone_set("America/La_Paz");

$caPOST = $_POST["ca"];
$ciPOST = $_POST["ci"];
$nombrePOST = $_POST["nombre"];
$apellidosPOST = $_POST["apellidos"];
$telefonoPOST = $_POST["telefono"];
$lugarPOST = $_POST["lugar"];
$correoPOST = $_POST["correo"];
$nivelPOST = $_POST["nivel"];

$cad_lider = '';
$val_lider = '';
if ($_POST['id_lider'] != '') {
	$liderPOST = $_POST['id_lider'];
	$cad_lider = ', lider';
	$val_lider = ', '.$liderPOST;
	// die($_POST['id_lider']);
}


// $fecha_alta = $_POST["fecha_alta"];

	$consultaBuscarCa = "SELECT * FROM clientes WHERE CA = ".$caPOST;
	$resultadoConsultaBCA = mysqli_query($conexion, $consultaBuscarCa) or die(mysqli_error($conexion));
	$datosConsultaBCA = mysqli_fetch_array($resultadoConsultaBCA);
	if(isset($datosConsultaBCA['CA'])){
		die('<script>mtoast("Ya existe un cliente con el Código Arbell: '.$caPOST.'" ,"warning")</script>');
	}

	
if ($nivelPOST == 1) {
	$nivelPOST = 'experta';
}else{
	$nivelPOST = 'lider';
}



$consultaAC="INSERT INTO `clientes`(`CA`,`CI`, `nombre`, `apellidos`, `telefono`, `lugar`, `correo`, `nivel` ".$cad_lider.") VALUES ('".$caPOST."','".$ciPOST."','".$nombrePOST."','".$apellidosPOST."','".$telefonoPOST."','".$lugarPOST."','".$correoPOST."','".$nivelPOST."' ".$val_lider.")";

	if(mysqli_query($conexion, $consultaAC) or die(mysqli_error($conexion))){
		die('registrado: '.$nivelPOST);
		// die('<script>Materialize.toast("<b>'.$nivelPOST.' agregado a la base de datos.</b>",5000);$("#modal1").closeModal();</script> ');
	}


?>