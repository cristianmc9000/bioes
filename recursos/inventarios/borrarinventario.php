<?php
//Conectamos a la base de datos
require('../conexion.php');
require('../sesiones.php');
session_start();

$idPOST = $_POST["id"];
$periodo = $_SESSION["periodo"];
// $year = $_SESSION['anio'];

	$consultaBorrar = "UPDATE inventario SET estado=0 WHERE id= '".$idPOST."'";
	if(mysqli_query($conexion, $consultaBorrar) or die(mysql_error())){
		die('?mes='.$periodo);
	}


?>