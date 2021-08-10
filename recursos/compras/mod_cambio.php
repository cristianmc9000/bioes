<?php 
require("../conexion.php");
$codc = $_GET['codc'];

if (isset($_GET['cambio'])) {
	$cambio = $_GET['cambio'];
	$conexion->query("UPDATE detalle_compra SET pubs = pupesos*".$cambio.", pubs_cd = pupesos_cd*".$cambio."  WHERE codc = ".$codc);
	$conexion->query("UPDATE compras SET valor_pesos = ".$cambio.", totalsd = (SELECT SUM(a.pubs*a.cantidad) as pubs FROM detalle_compra a WHERE a.codc = ".$codc."), totalcd = (SELECT SUM(a.pubs_cd*a.cantidad) as pubs_cd FROM detalle_compra a WHERE a.codc = ".$codc.") WHERE codc = ".$codc);
}
echo true;
?>