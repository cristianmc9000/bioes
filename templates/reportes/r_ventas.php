<?php 
require("../../recursos/sesiones.php");
require("../../recursos/conexion.php");
session_start();

$gestion = $_GET['ges'];
$periodo = $_GET['per'];

if ($periodo == 0) {
	$result = $conexion->query("SELECT a.codv, a.ca, b.nombre, b.apellidos, a.fecha, a.total, a.credito, a.descuento, a.valor_peso FROM ventas a, clientes b WHERE a.fecha LIKE '".$gestion."%' AND a.ca = b.CA AND a.estado = 1");
}else{
	if ($periodo == "6") {
		$per_a = "per".$periodo;
		$per_a = $gestion.$_SESSION[$per_a];
		$gestion = (int)$gestion+1;
		$per_b = "per1";
		$per_b = $gestion.$_SESSION[$per_b];
	}else{
		$per_a = "per".$periodo;
		$per_a = $gestion.$_SESSION[$per_a];
		$periodo = (int)$periodo+1;
		$per_b = "per".$periodo;
		$per_b = $gestion.$_SESSION[$per_b];
	}
	$result = $conexion->query("SELECT a.codv, a.ca, b.nombre, b.apellidos, a.fecha, a.total, a.credito, a.descuento, a.valor_peso FROM ventas a, clientes b WHERE (a.fecha BETWEEN '".$per_a."' AND '".$per_b."') AND a.ca = b.CA AND a.estado = 1");
}

	if((mysqli_num_rows($result))>0){
	  while($arr = $result->fetch_array()){ 
	        $fila[] = array('codv'=>$arr['codv'], 'ca'=>$arr['ca'], 'nombre'=>$arr['nombre'], 'apellidos'=>$arr['apellidos'], 'fecha'=>$arr['fecha'], 'total'=>$arr['total'], 'credito'=>$arr['credito'], 'descuento'=>$arr['descuento'], 'valor'=>$arr['valor_peso']); 
	  }
	}else{
	        $fila[] = array('codv'=>'--', 'ca'=>'--', 'nombre'=>'--', 'apellidos'=>'--', 'fecha'=>'--', 'total'=>'--', 'credito'=>'--', 'descuento'=>'--', 'valor'=>'--');
	}

?>
<style>
	.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #aaa;
    border-top-width: 1px;
    border-right-width: 1px;
    border-left-width: 1px;
    border-radius: 3px;
    padding: 5px;
    background-color: transparent;
    margin-bottom: 0px;
		margin-left: 0px;
		padding-bottom: 0px;
		padding-left: 0px;
		padding-top: 0px;
		padding-right: 0px;
		border-top-width: 0px;
		border-left-width: 0px;
		border-right-width: 0px;
  }
</style>
<title>reporte de compras</title>
<h3 class="fuente">Reporte de ventas</h3><br>
<div class="row">
	<div class="col s11">
		<table id="tabla1">
			<thead>
				<tr>
					<th>Código</th>
					<th>Código Arbell</th>
					<th>Nombres y apellidos</th>
					<th>Fecha de <br>venta</th>
					<th>Total (Bs.)</th>
					<th>Tipo de venta</th>
					<th>Descuento</th>
					<th>Valor de <br>cambio</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($fila as $a  => $valor){ ?>
				<tr>
					<td><?php echo $valor['codv']?></td>
					<td><?php echo $valor['ca']?></td>
					<td><?php echo $valor['nombre']." ".$valor['apellidos']?></td>
					<td><?php echo $valor['fecha']?></td>
					<td><?php echo $valor['total']?></td>
					<td><?php if($valor['credito'] == '0'){echo 'contado';}else{echo 'crédito';}?></td>
					<td><?php echo $valor['descuento']." %"?></td>
					<td><?php echo $valor['valor']." Bs."?></td>
				</tr>
			    <?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	    
$(document).ready(function() {
	$('#tabla1').dataTable({
      "order": [[ 0, "desc" ]],
      "language": {
	      "lengthMenu": "Registros _MENU_ por página",
	      "zeroRecords": "Lo siento, no se encontraron datos",
	      "info": "Página _PAGE_ de _PAGES_",
	      "infoEmpty": "No hay datos disponibles",
	      "infoFiltered": "(filtrado de _MAX_ resultados)",
	      "paginate": {
	        "next": "Siguiente",
	        "previous": "Anterior"
	      }},
		"dom": 'Bfrtip',
    "buttons":[
      {
        extend:     'excelHtml5',
        text:       '<i class="material-icons-outlined"><img src="https://img.icons8.com/material/24/000000/ms-excel--v1.png"/></i>',
        titleAttr:  'Exportar a Excel',
        className:  'btn-flat green',
        title: 			'Reporte de ventas del periodo: <?php echo $_GET["per"] ?>'
      },
      {
        extend:     'pdfHtml5',
        text:       '<i class="material-icons-outlined"><img src="https://img.icons8.com/material/24/000000/pdf-2--v1.png"/></i>',
        titleAttr:  'Exportar a PDF',
        className:  'btn-flat red',
        title: 			'Reporte de ventas del periodo: <?php echo $_GET["per"] ?>'
      },
      {
        extend:     'print',
        text:       '<i class="material-icons-outlined">print</i>',
        titleAttr:  'Imprimir',
        className:  'btn-flat blue',
        title: 			'<span style="font-size:30">Reporte del ventas del periodo: <?php echo $_GET["per"] ?> </span>'
      }
    ]
    });
})
</script>