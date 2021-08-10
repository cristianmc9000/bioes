<?php
//Conectamos a la base de datos
require('../conexion.php');


$ciPOST = $_POST["ci"];
$nombrePOST = $_POST["nombre"];
$apellidosPOST = $_POST["apellidos"];
$telefonoPOST = $_POST["telefono"];
$passwordPOST = $_POST["password"];
$password1POST = $_POST["password1"];
$rol = $_POST['rol'];


if($passwordPOST != $password1POST){
	die('<script> Materialize.toast("Las contraseñas no coinciden", 5000) </script>'); 
}



	// $consultaBuscarCi = "SELECT * FROM usuarios WHERE CI= '".$ciPOST."'";
	// $resultadoConsultaBCI = mysqli_query($conexion, $consultaBuscarCi) or die(mysql_error());


	// $datosConsultaBCI = mysqli_fetch_array($resultadoConsultaBCI);

	// if($datosConsultaBCI["CI"] != "" ){
	// 	die('<script> Materialize.toast("Ya existe usuario con el CI:'.$ciPOST.'") </script> ');
	// }
if ($passwordPOST != "") {
	$consultaAU = "UPDATE usuarios SET CI = ".$ciPOST.", nombre = '".$nombrePOST."', apellidos = '".$apellidosPOST."', telefono = ".$telefonoPOST.", password = '".$passwordPOST."', rol = ".$rol." WHERE CI = ".$ciPOST;
	$conexion->query($consultaAU);
	// echo mysqli_error($conexion);
	echo 1;
}else{
	$consultaAU = "UPDATE usuarios SET CI = ".$ciPOST.", nombre = '".$nombrePOST."', apellidos = '".$apellidosPOST."', telefono = ".$telefonoPOST.", rol = ".$rol." WHERE CI = ".$ciPOST;
	$conexion->query($consultaAU);
	// echo mysqli_error($conexion);
	echo 1;
}

?>