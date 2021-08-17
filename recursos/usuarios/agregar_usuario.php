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
	die('<script> mtoast("Las contraseñas no coinciden.", "danger") </script>'); 
}

	$consultaBuscarCi = "SELECT * FROM usuarios WHERE CI= '".$ciPOST."'";
	$resultadoConsultaBCI = mysqli_query($conexion, $consultaBuscarCi) or die(mysql_error());


	$datosConsultaBCI = mysqli_fetch_array($resultadoConsultaBCI);

	if($datosConsultaBCI["CI"] != "" ){
		die('<script> mtoast("Ya existe usuario con el CI:'.$ciPOST.'", "danger") </script> ');
	}

	$consultaAC ="INSERT INTO `usuarios`(`CI`, `nombre`, `apellidos`, `telefono`,`password`, `rol`) VALUES (".$ciPOST.",'".$nombrePOST."','".$apellidosPOST."',".$telefonoPOST.", '".$passwordPOST."', ".$rol.")";
	if(mysqli_query($conexion, $consultaAC)) {
		die('<script> mtoast("Usuario agregado a la base de datos.","success"); $("#modal1").modal("hide");</script> ');
	}else{
		die(mysqli_error($conexion));
	}


?>