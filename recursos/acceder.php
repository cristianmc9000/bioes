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

//PARA OBTENER EL PERIODO ACTUAL
$fecha = date("Y-m-d");
$actual_y = date("Y");

$array_index = array(
	$actual_y."-01-11", 
	$actual_y."-03-08",
	$actual_y."-05-10", 
	$actual_y."-07-12", 
	$actual_y."-09-14", 
	$actual_y."-11-16", 
	$actual_y."-01-11"
);

$indice = 0;
for($i=0; $i<count($array_index)-1; $i++){
	if(check_in_range($array_index[$i], $array_index[$i+1], $fecha)){
		$indice = $i;
		$i = count($array_index)-1;
	}else{
		$indice = $i;
	}
}
//FUNCION PARA REVISAR EL INTERVALO DE LA FECHA DEL PERIODO
function check_in_range($fecha_inicio, $fecha_fin, $fecha){
     $fecha_inicio = strtotime($fecha_inicio);
     $fecha_fin = strtotime($fecha_fin);
     $fecha = strtotime($fecha);
     if(($fecha >= $fecha_inicio) && ($fecha < $fecha_fin)){
         return true;
     }
     else{
         return false;
     }
 }

//Comprobamos si los datos son correctos
if($userBD == $userPOST and  $passPOST == $passwordBD){

	session_start();
	$_SESSION['usuario'] = $datos['nombre'];
	$_SESSION['apellidos'] = $datos['apellidos'];
	$_SESSION['rol'] = $datos['rol'];
	$_SESSION['estado'] = 'Autenticado';
	$_SESSION['userCI'] = $userBD;
	$_SESSION['periodox'] = $indice+1;

	//fechas inicio de periodos
	$_SESSION['per1'] = "-01-11";
	$_SESSION['per2'] = "-03-08";
	$_SESSION['per3'] = "-05-10";
	$_SESSION['per4'] = "-07-12";
	$_SESSION['per5'] = "-09-14";
	$_SESSION['per6'] = "-11-16";

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