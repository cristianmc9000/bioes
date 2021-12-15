<?php 
require("../conexion.php");

$codv=$_GET["codv"];
$result = $conexion->query("SELECT SUM(monto) as monto FROM pagos WHERE codv = ".$codv);
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
}
echo json_encode($rows);

?>