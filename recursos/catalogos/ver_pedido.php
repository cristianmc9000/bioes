<?php 
require('../sesiones.php');
require('../conexion.php');
session_start();
date_default_timezone_set("America/La_Paz");
$fecha_actual = date("Y-m-d H:i:s");
$ca = $_SESSION['ca'];


function fechaString ($fecha) {
  $fecha = substr($fecha, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $dia = date('l', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
}


$consulta = "SELECT * FROM pedidos WHERE ca = '".$ca."' ORDER BY id DESC LIMIT 1;";
$resultadoVP = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
$rvp = mysqli_fetch_array($resultadoVP);

// $_SERVER["REQUEST_TIME"]

$nuevo = strtotime($fecha_actual) - strtotime($rvp['fecha']);

if (($nuevo < 1800)  && ($rvp['estado'] == '2')) {
	$array = $rvp['total'].",".$rvp['fecha'].",".$rvp['id'].",ACEPTADO,".fechaString($rvp['fecha']).",".date("H:m:s", strtotime($rvp['fecha'])).",".$rvp['descuento'].",".$rvp['total_cd'];
	die($array);
}

if ($rvp['estado'] == 1) {
	$array = $rvp['total'].",".$rvp['fecha'].",".$rvp['id'].",PENDIENTE,".fechaString($rvp['fecha']).",".date("H:m:s", strtotime($rvp['fecha'])).",".$rvp['descuento'].",".$rvp['total_cd'];
	die($array);
}

if (($nuevo < 1800) && ($rvp['estado'] == 0)) {
	$array = $rvp['total'].",".$rvp['fecha'].",".$rvp['id'].",RECHAZADO,".fechaString($rvp['fecha']).",".date("H:m:s", strtotime($rvp['fecha'])).",".$rvp['descuento'].",".$rvp['total_cd'];
	die($array);
}else{
	die("sinpedidos");
}




?>