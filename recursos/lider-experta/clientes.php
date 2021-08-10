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
$fecha_alta = $_POST["fecha_alta"];

	$consultaBuscarCa = "SELECT * FROM clientes WHERE CA = ".$caPOST;
	$resultadoConsultaBCA = mysqli_query($conexion, $consultaBuscarCa) or die(mysql_error());
	$datosConsultaBCA = mysqli_fetch_array($resultadoConsultaBCA);
	if(isset($datosConsultaBCA['CA'])){
		die('<script>Materialize.toast("Ya existe un cliente con el Código Arbell: '.$caPOST.'" ,5000)</script>');
	}

	
if ($nivelPOST == 1) {
	$nivelPOST = 'experta';
}else{
	$nivelPOST = 'lider';
}

	$consultaAC ="INSERT INTO `clientes`(`CA`,`CI`, `nombre`, `apellidos`, `telefono`, `lugar`, `correo`, `nivel`, `fecha_alta`) VALUES ('".$caPOST."','".$ciPOST."','".$nombrePOST."','".$apellidosPOST."','".$telefonoPOST."','".$lugarPOST."','".$correoPOST."','".$nivelPOST."', '".$fecha_alta."')";
	if(mysqli_query($conexion, $consultaAC) or die(mysql_error())){
		die('registrado: '.$nivelPOST);
		// die('<script>Materialize.toast("<b>'.$nivelPOST.' agregado a la base de datos.</b>",5000);$("#modal1").closeModal();</script> ');
	}


?>