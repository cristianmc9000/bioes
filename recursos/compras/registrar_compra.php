<?php 


//FALTA RECUEPRAR USUARIO CI: DE LA SESSION
require("../conexion.php");
require("../sesiones.php");
session_start();
$userci = $_SESSION['userCI'];
date_default_timezone_set("America/La_Paz");
$fecha = date("Y-m-d h:i:s");

$array = json_decode($_POST["json"]);

//atributos de la compra
$valor = array_pop($array);
// $descuento = array_pop($array);
$total_sd = array_pop($array);
$total_cd = array_pop($array);
$array_normal = $array;
// die($array['0']->combo); para obtener valor especifico de stdClass
$cont = 0 ;
$array_combo = array();
foreach($array_normal as $arr){
	if ($arr->{'combo'} == "1") {
		// $key = array_search($arr->{'id'}, $array);
		// unset($array[$key]);
		// $ac = [
		// 	"id" => $arr->{'id'},
		// 	"cantidad" => $arr->{'cantidad'}
		// ];
		// array_push($array_combo, $ac);

		unset($array_normal[$cont]);
		$respuesta = $conexion->query("SELECT id_prod FROM combo WHERE id_combo = '".$arr->{'id'}."'");
		foreach ($respuesta as $key) {
			$ac = [
			"id" => $key['id_prod'],
			"cantidad" => $arr->{'cantidad'}
			];
			array_push($array_combo, $ac);
		}
	}
	$cont ++;
}
// $array = json_encode($array);
// die(var_dump($array_normal));


//insertar un nuevo registro de compra en tabla: compras
$insertarCompra = "INSERT INTO `compras`(`ci_usu`,`fecha`,`totalsd`, `totalcd`,`valor_pesos`) VALUES ('".$userci."','".$fecha."',".$total_sd->{'_totalsd'}.", ".$total_cd->{'_totalcd'}.", ".$valor->{'_valor'}." )";
mysqli_query($conexion, $insertarCompra);


//obtener el último id autogenerado tabla: compras
$ultimoid = var_export(mysqli_insert_id($conexion), true);

//insertar nuevo detalle de compra tabla: detalle_compra
$sql = mysqli_prepare($conexion, "INSERT INTO detalle_compra (codc, codp, cantidad, descuento, pupesos, pubs, pupesos_cd, pubs_cd) VALUES (?,?,?,?,?,?,?,?);");
$respuesta = false;
foreach ($array as $arr) {
	mysqli_stmt_bind_param($sql, 'isiidddd', $ultimoid, $arr->{'id'}, $arr->{'cantidad'}, $arr->{'descuento'}, $arr->{'pupesos'}, $arr->{'pubs'}, $arr->{'pupesos_desc'}, $arr->{'pubs_desc'});
	$respuesta = mysqli_stmt_execute($sql);
}
mysqli_stmt_close($sql);


//Insertar datos a tabla: inventario
$res = false;
// $cad ="";
$insertarinv = mysqli_prepare($conexion, "INSERT INTO inventario (codp, pupesos, pubs, cantidad, fecha_reg) VALUES(?,?,?,?,?);");
foreach ($array_normal as $arr) {
	mysqli_stmt_bind_param($insertarinv, 'sddis', $arr->{'id'}, $arr->{'pupesos'}, $arr->{'pubs'}, $arr->{'cantidad'}, $fecha);
	$res = mysqli_stmt_execute($insertarinv);
	// $cad = mysqli_stmt_error();
}
mysqli_stmt_close($insertarinv);

//insertar datos a tabla: invcant
// $insertarinvcant = mysqli_prepare($conexion, "UPDATE invcant SET cantidad = cantidad+? WHERE codp = ?;");
foreach ($array_normal as $arr) {
	// mysqli_stmt_bind_param($insertarinvcant, 'is', $arr->{'cantidad'}, $arr->{'id'});
	// mysqli_stmt_execute($insertarinvcant);
	$conexion->query("UPDATE invcant a SET a.cantidad = (SELECT IF((SELECT SUM(b.cantidad) FROM inventario b WHERE b.estado = 1 AND b.codp = '".$arr->{'id'}."')>0, (SELECT SUM(b.cantidad) FROM inventario b WHERE b.estado = 1 AND b.codp = '".$arr->{'id'}."'),0)) WHERE a.codp = '".$arr->{'id'}."'");
}
// mysqli_stmt_close($insertarinvcant);



//Insertar datos de productos combo a tabla: inventario
$res = false;
// $cad ="";
// die(var_dump($array_combo));
$insertarinv_combo = mysqli_prepare($conexion, "INSERT INTO inventario (codp, cantidad, fecha_reg) VALUES(?,?,?);");
foreach ($array_combo as $arr) {

	mysqli_stmt_bind_param($insertarinv_combo, 'sis', $arr['id'], $arr['cantidad'], $fecha);
	$res = mysqli_stmt_execute($insertarinv_combo);
	// $cad = mysqli_stmt_error($insertarinv_combo);
}
mysqli_stmt_close($insertarinv_combo);


//insertar datos combo a tabla: invcant
// $insertarinvcant = mysqli_prepare($conexion, "UPDATE invcant SET cantidad = cantidad+? WHERE codp = ?;");
foreach ($array_combo as $arr) {
	// mysqli_stmt_bind_param($insertarinvcant, 'is', $arr->{'cantidad'}, $arr->{'id'});
	// mysqli_stmt_execute($insertarinvcant);
	$res_invcant = $conexion->query("UPDATE invcant a SET a.cantidad = (SELECT IF((SELECT SUM(b.cantidad) FROM inventario b WHERE b.estado = 1 AND b.codp = '".$arr['id']."')>0, (SELECT SUM(b.cantidad) FROM inventario b WHERE b.estado = 1 AND b.codp = '".$arr['id']."'),0)) WHERE a.codp = '".$arr['id']."'");
}
// mysqli_stmt_close($insertarinvcant);
// die($res_invcant);


echo $ultimoid;




?>
