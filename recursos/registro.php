<?php
//Conectamos a la base de datos
require('conexion.php');

//Obtenemos los datos del formulario de registro

$nombrePOST = $_POST["nombre"];
$apellidosPOST = $_POST["apellidos"];
$telefonoPOST = $_POST["telefono"];

$userPOST = $_POST["userRegistro"]; 
$passPOST = $_POST["passRegistro"];


//Filtro anti-XSS

$nombrePOST = htmlspecialchars(mysqli_real_escape_string($conexion, $nombrePOST));
$apellidosPOST = htmlspecialchars(mysqli_real_escape_string($conexion, $apellidosPOST));
$telefonoPOST = htmlspecialchars(mysqli_real_escape_string($conexion, $telefonoPOST));

$userPOST = htmlspecialchars(mysqli_real_escape_string($conexion, $userPOST));
$passPOST = htmlspecialchars(mysqli_real_escape_string($conexion, $passPOST));

//Definimos la cantidad máxima de caracteres
//Esta comprobación se tiene en cuenta por si se llegase a modificar el "maxlength" del formulario
//Los valores deben coincidir con el tamaño máximo de la fila de la base de datos

$maxCaracteresNombre = "15";
$maxCaracteresApellidos = "40";
$maxCaracteresTelefono = "20";

$maxCaracteresUsername = "10";
$maxCaracteresPassword = "20";

//Si los input son de mayor tamaño, se "muere" el resto del código y muestra la respuesta correspondiente

if(strlen($nombrePOST) > $maxCaracteresNombre) {
	die('<script>$("#modal1").openModal();</script> El nombre de usuario no puede superar los '.$maxCaracteresNombre.' caracteres');
};
if(strlen($apellidosPOST) > $maxCaracteresApellidos) {
	die('<script>$("#modal1").openModal();</script> Los apellidos no pueden superar los '.$maxCaracteresApellidos.' caracteres');
};
if(strlen($telefonoPOST) > $maxCaracteresTelefono) {
	die('<script>$("#modal1").openModal();</script> El teléfono no puede superar los '.$maxCaracteresTelefono.' caracteres');
};


if(strlen($userPOST) > $maxCaracteresUsername) {
	die('<script>$("#modal1").openModal();</script> La cédula de identidad puede superar los '.$maxCaracteresUsername.' caracteres');
};

if(strlen($passPOST) > $maxCaracteresPassword) {
	die('<script>$("#modal1").openModal();</script> La contraseña no puede superar los '.$maxCaracteresPassword.' caracteres');
};


//Escribimos la consulta necesaria
$consultaUsuarios = "SELECT ci FROM `usuarios`";

//Obtenemos los resultados
$resultadoConsultaUsuarios = mysqli_query($conexion, $consultaUsuarios) or die(mysql_error());



//Si el input de usuario o contraseña está vacío, mostramos un mensaje de error
//Si el valor del input del usuario es igual a alguno que ya exista, mostramos un mensaje de error
if(empty($nombrePOST) || empty($apellidosPOST) || empty($userPOST) || empty($passPOST)) {
	
	die('<script>$("#modal1").openModal();</script> Debes introducir datos válidos');
}

$variable=false;
$hayResultados = true;
while ($hayResultados==true){
	$datosConsultaUsuarios = mysqli_fetch_array($resultadoConsultaUsuarios);
	if ($datosConsultaUsuarios) { 
		$userBD = $datosConsultaUsuarios['ci'];
		if ($userPOST == $userBD){
			$variable=true;
		}

	} else {$hayResultados = false;}
}
if ($variable) {
	die('<script>$("#modal1").openModal();</script> Ya existe un usuario con la Cédula de identidad: '.$userPOST.'');
}
else {
//Si no hay errores, procedemos a encriptar la contraseña
//Lectura recomendada: https://mimentevuela.wordpress.com/2015/10/08/establecer-blowfish-como-salt-en-crypt-2/
	function aleatoriedad() {
		$caracteres = "abcdefghijklmnopqrstuvwxyz1234567890";
		$nueva_clave = "";
		for ($i = 5; $i < 35; $i++) {
			$nueva_clave .= $caracteres[rand(5,35)];
		};
		return $nueva_clave;
	};

	$aleatorio = aleatoriedad();
	$valor = "07";
	$salt = "$2y$".$valor."$".$aleatorio."$";

	$passwordConSalt = crypt($passPOST, $salt);

	//Armamos la consulta para introducir los datos
	$consulta = "INSERT INTO `usuarios` (ci, nombre, apellidos, telefono, password) 
	VALUES ('$userPOST', '$nombrePOST' , '$apellidosPOST', '$telefonoPOST', '$passwordConSalt')";
	
	//Si los datos se introducen correctamente, mostramos los datos
	//Sino, mostramos un mensaje de error
	if(mysqli_query($conexion, $consulta)) {
		die('<script>$(".registro").val(""); $("#modal1").openModal();</script>
Registrado con éxito <br>
Ya puedes acceder a tu cuenta <br>
<br>
Datos:<br>
CI: '.$userPOST.'<br>
Nombre: '.$nombrePOST.'<br>
Apellidos: '.$apellidosPOST.'<br>
Teléfono: '.$telefonoPOST.'<br>
Contraseña: '.$passPOST);
	} else {
		die('Error');
	};
};//Fin comprobación if(empty($userPOST) || empty($passPOST))
?>