<?php 
require("../conexion.php");
$codv=$_GET["codv"];

$result = $conexion->query("SELECT a.codv, a.id, a.monto, a.fecha_pago, b.total FROM pagos a, ventas b WHERE a.estado = 1 AND a.codv = b.codv AND a.codv = ".$codv);
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
}
echo json_encode($rows);

?>