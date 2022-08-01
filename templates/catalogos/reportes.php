<?php 
// session_start();
// require('../../recursos/conexion.php');
// $ca = $_SESSION['ca'];

// $result = $conexion->query("SELECT * FROM clientes WHERE estado = 1 AND lider = ".$ca);
// $result = $result->fetch_all(MYSQLI_ASSOC);
	date_default_timezone_set("America/La_Paz");

	if (isset($_GET['ges'])) {
		$ges = $_GET['ges'];
	}else{
		$ges = date("Y");
	}

	if (isset($_GET['per'])) {
		$per = $_GET['per'];
	}else{
		$per = "0";
		$per_value = 'Todos';
	}
	

?>

<style>

</style>
<br>
<div class="container">
		<div class="input-field col s6">
	    <select id="reporte_gestion">
	      <option value="<?php echo $ges ?>" disabled selected><?php echo $ges ?></option>
	      <option value="2021">2021</option>
	      <option value="2022">2022</option>
	      <option value="2023">2023</option>
	      <option value="2024">2024</option>
	    </select>
	    <label>Gestión</label>
  	</div>
		<div class="input-field col s6">
	    <select id="reporte_periodo">
	      <option value="<?php echo $per ?>" disabled selected><?php echo $per_value ?></option>
	      <option value="0">Todos</option>
	      <option value="1">Periodo 1</option>
	      <option value="2">Periodo 2</option>
	      <option value="3">Periodo 3</option>
	      <option value="4">Periodo 4</option>
	      <option value="5">Periodo 5</option>
	      <option value="6">Periodo 6</option>
	    </select>
	    <label>Periodo</label>
  	</div>
</div>
<div class="container">
<br>
	<table id="tabla_reportes" class="content-table centered z-depth-4">
		<thead>
			<tr>
				<th>Código</th>
				<th>Experta</th>
				<th>Items</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody style="font-size: 0.9em">
			<td colspan="4">No existen datos.</td>
		</tbody>
	</table>

</div>

	 <div id="modal_reporte_experta" class="modal roboto">
    <div class="modal-content" >
      <div class="center">
      	<h6 id="modal_title" class="rubik" style=" font-weight: bold;">Datos de experta</h6><br>
      </div>
      <div>
					<table class="det rubik z-depth-4">
						<tr>
							<th width="20%">Experta:</th>
							<td><span id="mr_experta"></span></td>
						</tr>
						<tr>
							<th width="20%">CA:</th>
							<td><span id="mr_ca"></span></td>
						</tr>
						<tr>
							<th >CI:</th>
							<td><span id="mr_ci"></span></td>
						</tr>
						<tr>
							<th>Celular:</th>
							<td><span id="mr_celular"></span></td>
						</tr>
						<tr>
							<th>Dirección:</th>
							<td><span id="mr_dir"></span></td>
						</tr>
					</table>
    	</div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-light btn right">Aceptar</a>
    </div>
  </div>


<script>
	$(document).ready(function() {
		$("#titulo").html('Reportes');
		$('.modal').modal();
		$('select').formSelect();

		fetch('recursos/catalogos/reportes.php')
			.then(response => {
				response.json().then(res => {
					// console.log(res)
					cargar_tabla(res);
				})
			})

	});

	function datos_experta(ca, experta, ci, telf, lugar) {
		let instance = M.Modal.getInstance(document.getElementById('modal_reporte_experta'))
		document.getElementById('mr_experta').innerHTML = experta
		document.getElementById('mr_ca').innerHTML = ca
		document.getElementById('mr_ci').innerHTML = ci
		document.getElementById('mr_celular').innerHTML = telf
		document.getElementById('mr_dir').innerHTML = lugar
		instance.open();
	}
 		    
	document.getElementById('reporte_gestion').addEventListener('change', () =>{
		let ges = document.getElementById('reporte_gestion').value;
		let per = document.getElementById('reporte_periodo').value;
		fetch('recursos/catalogos/reportes.php?ges='+ges+'&per='+per)
		.then(response => response.json())
		.then(data => {
			cargar_tabla(data);
		})
	})

	document.getElementById('reporte_periodo').addEventListener('change', () =>{
		let ges = document.getElementById('reporte_gestion').value;
		let per = document.getElementById('reporte_periodo').value;
		fetch('recursos/catalogos/reportes.php?ges='+ges+'&per='+per)
		.then(response => response.json())
		.then(data => {
			cargar_tabla(data);
		})
	})

	function cargar_tabla(res) {
		let cad = "";

		res.sort(function(a, b){
			return parseFloat(a.total) < parseFloat(b.total);
		})
		
		if (res.length > 0) {
						res.forEach(function(item, index, res){
							cad = cad + `<tr><td><a href="#" onclick="datos_experta('${item.ca}', '${item.experta}','${item.CI}', '${item.telefono}', '${item.lugar}')">${item.ca}</a></td><td>${item.experta}</td><td>${item.cant}</td><td>${parseFloat(item.total).toFixed(1)} Bs.</td></tr>`
						})
		}else{
			cad = `<tr><td colspan="4">No se encontraron registros.</td></tr>`
		}
		document.getElementById('tabla_reportes').children[1].innerHTML = cad;
	}
</script>