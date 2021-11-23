<?php
//Conectamos a la base de datos
require('../conexion.php');
require('../sesiones.php');
session_start();

$idPOST = $_POST["id"];
$periodo = $_SESSION["periodo"];
$year = $_SESSION['anio'];

$result = $conexion->query("SELECT SUM(cantidad) as cant FROM inventario WHERE codp = '".$idPOST."'");
$cant = $result->fetch_assoc();
$cantidad = $cant['cant'];

if ($cantidad < 1) {
	$res = $conexion->query("SELECT combo FROM productos WHERE id = '".$idPOST."'");
	$combo = $res->fetch_array();
	if ($combo['0'] == 1) {
		$conexion->query("DELETE FROM `combo` WHERE id_combo = '".$idPOST."'");
	}
	
	$conexion->query("DELETE FROM invcant WHERE codp = '".$idPOST."'");
	$conexion->query("DELETE FROM inventario WHERE codp = '".$idPOST."'");
	$consultaBorrar = "DELETE FROM `productos` WHERE id = '".$idPOST."'";
	if(mysqli_query($conexion, $consultaBorrar) or die(mysqli_error($conexion))){
		die("1");
	}
}else{
	die("<script>mtoast('No se puede eliminar, tiene productos activos en inventario.', 'warning')</script>");
	
}

?>


<!-- FALTA COMPLETAR AGREGAR PRODUCTOS .... -->