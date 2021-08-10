<?php
require('../conexion.php');
require('../sesiones.php');
session_start();
$periodo = $_SESSION["periodo"];
$nombre = $_POST["linea_"];

$sql = $conexion->query("INSERT INTO  lineas (nombre, periodo) VALUES ('".$nombre."', ".$periodo.")");

echo "?mes=".$periodo;


?>