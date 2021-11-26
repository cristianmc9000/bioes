<?php
//Conectamos a la base de datos
require('../conexion.php');
require('../sesiones.php');
session_start();

$idPOST = $_GET["id"];
$codp = $_GET['codp'];
// $periodo = $_SESSION["periodo"];
// $year = $_SESSION['anio'];
// die($idPOST);
	$consultaBorrar = "UPDATE inventario SET estado=0 WHERE id= '".$idPOST."'";
	mysqli_query($conexion, $consultaBorrar) or die(mysqli_error($conexion));
	

	$res = $conexion->query("UPDATE invcant a SET a.cantidad = (SELECT IF((SELECT SUM(b.cantidad) FROM inventario b WHERE b.estado = 1 AND b.codp = '".$codp."')>0, (SELECT SUM(b.cantidad) FROM inventario b WHERE b.estado = 1 AND b.codp = '".$codp."'),0)) WHERE a.codp = '".$codp."'");

	if ($res == '1') {
		die($res);
	}else{
		die(mysqli_error($conexion));
	}
?>