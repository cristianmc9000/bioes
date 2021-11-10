<?php
require("../conexion.php"); 
$codv=$_GET["codv"];
$result= $conexion->query("SELECT a.codv, b.linea as codli, a.codp,e.ca,(SELECT CONCAT_WS (' ',f.nombre, f.apellidos)FROM clientes f WHERE f.CA = (SELECT g.ca FROM ventas g WHERE g.codv = ".$codv.")) AS cliente, e.credito, (SELECT c.nombre FROM lineas c WHERE b.linea = c.codli) as linea, b.descripcion, a.cantidad, a.pubs, a.pubs_cd FROM detalle_venta a, productos b, ventas e WHERE e.codv = a.codv AND a.codp = b.id AND a.codv = ".$codv);
// (SELECT MAX(d.periodo) FROM productos d WHERE d.id = a.codp) AS periodo <-- esto se usaba para obtener el periodo actual (ahora obtenemos el periodo actual desde la tabla)
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
}

// echo $rows[0]['codv']; //reading a single element of array
echo json_encode($rows);


?>