<?php
//Conectamos a la base de datos
require('../conexion.php');


$idPOST = $_POST["id"];

	$consultaBorrarCliente = "UPDATE clientes SET estado=0 WHERE id= '".$idPOST."'";
	if(mysqli_query($conexion, $consultaBorrarCliente) or die(mysql_error())){
		die('<script>$("#modal4").modal("hide"); mtoast("Lider/Experta eliminado", "success")</script>');
	}

?>