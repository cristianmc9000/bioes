<?php 
require("../conexion.php");
require("../sesiones.php");
session_start();
$ca = $_GET['ca'];
$per = $_SESSION['periodox'];

$result = $conexion->query("SELECT credito FROM ventas WHERE ca = ".$ca." AND credito = 1 AND periodo != ".$per);
$row_cnt = $result->num_rows;

if ($row_cnt > 0) {
	echo 1;
}else{
	echo 0;
}

?>