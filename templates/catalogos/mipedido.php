<?php
require('../../recursos/conexion.php');
session_start();
$Sql = "SELECT a.codped, b.descripcion, a.cant, a.pubs, a.pubs_cd, c.total, c.ca, CONCAT_WS(' ',d.nombre,d.apellidos) as cliente FROM detalle_pedido a, productos b, pedidos c, clientes d WHERE a.codpro = b.id AND a.codped = c.id AND c.ca = d.CA AND c.CA = '".$_SESSION['ca']."'";
$Busq = $conexion->query($Sql);

if((mysqli_num_rows($Busq))>0){
while($arr = $Busq->fetch_array())
{
$fila[] = array('codped'=>$arr['codped'], 'descripcion'=>$arr['descripcion'], 'cant'=>$arr['cant'], 'pubs'=>$arr['pubs'], 'pubs_cd'=>$arr['pubs_cd'], 'total'=>$arr['total'], 'cliente'=>$arr['cliente']);
}}else{
    $fila[] = array('codped'=>'---', 'descripcion'=>'---', 'cant'=>'---', 'pubs'=>'---', 'pubs_cd'=>'---', 'total'=>'---', 'cliente'=>'---');
}
?>



<style>
	body{
		/*font-family: 'Segoe UI Light';*/
		/*background-color: #ffbb00;*/
	}
	.textrev{
		color: #eeee00;
	}
	.det{
		/*border: 3px solid black;*/
		background-color: white;
	}
	.btn-cancelar{

	}

	@media (max-width: 600px) {

		.btn-cancelar{
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100% !important;
        -ms-transform: none;
        transform: none;
		}
	}

</style>
<br>

<div id="404" class="col s12 m6 offset-m3 valign-wrapper" style="height: 60vh;">
		<h2 class="roboto center">No tienes pedidos activos! <br> &#129335 </h2>
</div>


<!-- <div id="cabezal" class="center dancing"><h4>Mi pedido</h4></div> -->

<div id="contenido" class="row rubik" >
	<div class="col s12">
		<table class="det rubik z-depth-4">
			<tr>
				<th>Estado: </th>
				<td><span id="actped"></span></td>
			</tr>
			<tr>
				<th>Fecha: </th>
				<td><span id="fecha_ped"></span></td>
			</tr>
			<tr>
				<th>Hora: </th>
				<td><span id="hora_ped"></span></td>
			</tr>
		</table>
		<!-- <p class="rubik">Estado del pedido: <span id="actped"></span></p> -->
		<!-- <span id="fecha_ped"></span> -->

	</div>

	<div class="col s12 m12 l12" style="margin-top: 10px;">
		<table id="pedidos_cliente" class="det centered content-table z-depth-4">
			<thead>
				<tr>
					<th>PRODUCTO</th>
					<th>CANTIDAD</th>
					<th>PRECIO Bs.</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="3">Sin pedidos activos...</td>
				</tr>
			</tbody>
		</table>
		
	</div>

	<div class="col s12 m12 l12" style="margin-top: 15px;">
		<p><span id="totped"></span></p>
		<p><span id="totped_cd"></span></p>
	</div>
	

</div>
<div class="col s12 center">
	<a class="btn-large red " id="boton-cancelar">CANCELAR MI PEDIDO</a>
</div>
<!-- Modal cancelar_pedido -->
<div class="row">
	<div id="modal_cancelar_pedido" class="modal rubik">  <!-- col s12 m4 offset-m4 controlado por pedidos.css--> 
		<div id="cont_cancelar_pedido" class="modal-content">
			<p><h4>Su pedido será cancelado.</h4></p>
			<input type="text" id="codigo_ped" hidden>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect waves-light btn-large green left">Cerrar</a>
			<a href="#!" class="waves-effect waves-light btn-large red right" onclick="confirmar_cancel()">Confirmar</a>
		</div>
	</div>
</div>


<script>

	$(document).ready(function() {
		$("#titulo").html('Mi pedido');
		$(".modal").modal();
	    $.ajax({
            url: "recursos/catalogos/ver_pedido.php",
            success: function(echo) {
                // console.log(echo)
				var arr = echo.split(",");
				// console.log(arr)
				if (echo == "sinpedidos") {
					$('#actped').css('color', 'red');
					$('#actped').html("No tienes pedidos activos.");
					$('#totped').html("");
					$("#totped_cd").html("");
					$('#fecha_ped').html("");
					$("#boton-cancelar").hide();
					$("#contenido").hide()
					$("#cabezal").hide()
					$("#404").show()
					// document.getElementById("boton-cancelar").hidden = true;
					return console.log('sin pedidos...');
				}

				if (arr[3] == "PENDIENTE") {
					// $('#actped').css('color', '#f6e58d');
					$("#contenido").show()
					$("#cabezal").show()
					$("#404").hide()
					$('#actped').html('Tienes 1 pedido pendiente, tu pedido aun no ha sido aceptado.');
					$('#totped').html('<b>Subtotal:</b> '+arr[0]+'Bs.');
					$("#totped_cd").html('<b>Total con descuento:</b> '+arr[7]+'Bs.');
					$('#fecha_ped').html(arr[4]);
					$("#hora_ped").html(arr[5]);
					// $("#boton-cancelar").html("<a class='btn-large red' onclick='cancelar_pedido("+arr[2]+")'>CANCELAR MI PEDIDO</a>");
					$("#boton-cancelar").show();
					$("#boton-cancelar").attr("onclick","cancelar_pedido("+arr[2]+")");
					tabla_llenar(arr[2]);
				}
				if (arr[3] == "ACEPTADO"){
					$("#contenido").show()
					$("#cabezal").show()
					$("#404").hide()
					$('#actped').css('color', '#329f21');
					$('#actped').html('Tu pedido ha sido aceptado.');
					$('#totped').html('<b>Subtotal:</b> '+arr[0]+'Bs.');
					$("#totped_cd").html('<b>Total con descuento:</b> '+arr[7]+'Bs.');
					$('#fecha_ped').html(arr[4]);
					$("#hora_ped").html(arr[5]);
					// $("#boton-cancelar").html("");
					$("#boton-cancelar").hide();
					tabla_llenar(arr[2]);
				}

				if (arr[3] == "RECHAZADO") {
					$("#contenido").show()
					$("#cabezal").show()
					$("#404").hide()
					$('#actped').css('color', 'orange');
					$('#actped').html('Tu pedido fue rechazado.');
					$('#totped').html('<b>Total:</b> '+arr[0]+'Bs.');
					$("#totped_cd").html('<b>Total con descuento:</b> '+arr[7]+'Bs.');
					$('#fecha_ped').html(arr[4]);
					$("#hora_ped").html(arr[5]);
					// $("#boton-cancelar").html("<a class='btn-large red' onclick='cancelar_pedido("+arr[2]+")'>CANCELAR MI PEDIDO</a>");
					// $("#boton-cancelar").show();
					// $("#boton-cancelar").attr("onclick","cancelar_pedido("+arr[2]+")");
					$("#boton-cancelar").hide();
					tabla_llenar(arr[2]);
				}
            },
            error: function(error) {
                console.log(error)
            }
	    })

	});

		

	function tabla_llenar (cod){
		$("#pedidos_cliente tbody").html("")
		var table = $("#pedidos_cliente tbody")[0];

		"<?php foreach($fila as $a  => $valor){ ?>";
			if(cod == "<?php echo $valor['codped'] ?>"){
				var row = table.insertRow(-1);
				row.insertCell(0).innerHTML = "<?php echo $valor['descripcion'] ?>";
				row.insertCell(1).innerHTML = "<?php echo $valor['cant'] ?>";
				row.insertCell(2).innerHTML = Number(parseFloat("<?php echo $valor['pubs'].' Bs.'?>").toFixed(1));
			}
		"<?php } ?>";
	}

	function cancelar_pedido(cod) {
		console.log(cod)
		$("#codigo_ped").val(cod);
		$("#modal_cancelar_pedido").modal('open');

	}

	function confirmar_cancel() {
		let cod = $("#codigo_ped").val();
		$.ajax({
            url: "recursos/catalogos/cancel_ped.php?cod="+cod,
            method: "GET",
            success: function(response) {
                console.log(response)
                if (response == '11') {
                	M.toast({html:'Su pedido ha sido cancelado.'}); 
					$('#modal_cancelar_pedido').modal('close');
					$('#actped').css('color', 'red');
					$('#actped').html("Pedido cancelado, no tienes pedidos activos.");
					$('#totped').html("");
					$('#totped_cd').html("");
					$('#fecha_ped').html("");
					$('#hora_ped').html("");
					$('#boton-cancelar').hide();

                }
            },
            error: function(error) {
                console.log(error)
            }
	    })

	}


</script>
