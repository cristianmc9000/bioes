<?php 
require("../conexion.php");
require("../sesiones.php");
session_start();
$gestion = $_GET['ges'];
$periodo = $_GET['per'];

echo $gestion."---".$periodo;
?>
