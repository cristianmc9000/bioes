<?php
	
//Conectamos a la base de datos
require('conexion.php');
date_default_timezone_set("America/La_Paz");
//Obtenemos los datos del formulario de acceso
$userPOST = $_POST["userAcceso"]; 
$passPOST = $_POST["passAcceso"];

//Filtro anti-XSS
$userPOST = htmlspecialchars(mysqli_real_escape_string($conexion, $userPOST));
$passPOST = htmlspecialchars(mysqli_real_escape_string($conexion, $passPOST));

//Definimos la cantidad máxima de caracteres
//Esta comprobación se tiene en cuenta por si se llegase a modificar el "maxlength" del formulario
//Los valores deben coincidir con el tamaño máximo de la fila de la base de datos
$maxCaracteresUsername = "10";
$maxCaracteresPassword = "60";

//Si los input son de mayor tamaño, se "muere" el resto del código y muestra la respuesta correspondiente
if(strlen($userPOST) > $maxCaracteresUsername) {
	die('<script>$("#modal1").openModal();</script> El nombre de usuario no puede superar los '.$maxCaracteresUsername.' caracteres');
};

if(strlen($passPOST) > $maxCaracteresPassword) {
	die('<script>$("#modal1").openModal();</script> La contraseña no puede superar los '.$maxCaracteresPassword.' caracteres');
};


//Escribimos la consulta necesaria
$consulta = "SELECT * FROM `usuarios` WHERE CI='".$userPOST."'";

//Obtenemos los resultados
$resultado = mysqli_query($conexion, $consulta);
$datos = mysqli_fetch_array($resultado);

//Guardamos los resultados del nombre de usuario en minúsculas
//y de la contraseña de la base de datos
$userBD = $datos['CI'];
$passwordBD = $datos['password'];
//$sucursal = $datos['sucursal'];


//Comprobamos si los datos son correctos
if($userBD == $userPOST and  $passPOST == $passwordBD){

	session_start();
	$_SESSION['usuario'] = $datos['nombre'];
	$_SESSION['apellidos'] = $datos['apellidos'];
	$_SESSION['rol'] = $datos['rol'];
	$_SESSION['estado'] = 'Autenticado';
	$_SESSION['userCI'] = $userBD;
	// $_SESSION['periodox'] = $indice+1;


	/* Sesión iniciada, si se desea, se puede redireccionar desde el servidor */



//Si los datos no son correctos, o están vacíos, muestra un error
//Además, hay un script que vacía los campos con la clase "acceso" (formulario)
} else if ( $userBD != $userPOST || $userPOST == "" || $passPOST == "" || $passPOST != $passwordBD)  {
	die ('<script>Materialize.toast("Los datos de acceso son incorrectos", 4000);</script>
Los datos de acceso son incorrectos');
} else {
	die('Error');
};
?>