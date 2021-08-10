
<?php 
require("../conexion.php");
date_default_timezone_set("America/La_Paz");
$codv = $_GET['codv'];
$monto = $_GET['monto'];
$fecha = date("Y-m-d h:i:s");

$result = $conexion->query("INSERT INTO pagos (codv, monto, fecha_pago) VALUES(".$codv.", ".$monto.", '".$fecha."')");

$sql = $conexion->query("SELECT SUM(monto) as monto FROM pagos WHERE estado = 1 AND codv = ".$codv);
$monto = $sql->fetch_array(MYSQLI_ASSOC);

$sql2 = $conexion->query("SELECT total FROM ventas WHERE codv = ".$codv);
$total = $sql2->fetch_array(MYSQLI_ASSOC);

$monto = (float)$monto["monto"];
$total = (float)$total["total"];

if ($monto >= $total) {
	$conexion->query("UPDATE ventas SET credito = 2 WHERE codv = ".$codv);
}

$ultimo_pago = $conexion->query("SELECT * FROM `pagos` ORDER BY id DESC LIMIT 1");
$pago = $ultimo_pago->fetch_array(MYSQLI_ASSOC);


echo json_encode($pago);
?>