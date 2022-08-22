<?php 
require("../../recursos/conexion.php");


$fecha1 = $_GET['fecha1'];
$fecha2 = $_GET['fecha2'];

	$result = $conexion->query("SELECT a.codv, a.ca, b.nombre, b.apellidos, a.fecha, a.total, a.credito, a.valor_peso FROM ventas a, clientes b WHERE (a.fecha BETWEEN '".$fecha1."' AND '".$fecha2."') AND a.ca = b.CA AND a.estado = 1");

	$fila = $result->fetch_all(MYSQLI_ASSOC);

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
	<div class="col-sm-11">
		<table id="tabla1" >
			<thead>
				<tr>
					<th>Código</th>
					<th>Código Bio</th>
					<th>Nombres y apellidos</th>
					<th>Fecha de <br>venta</th>
					<th>Total (Bs.)</th>
					<th>Tipo de venta</th>
					<!-- <th>Descuento</th> -->
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
					<!-- <td><?php echo $valor['descuento'] ?></td> -->
					<td><?php echo $valor['valor_peso']." Bs."?></td>
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
        title: 			'Reporte de ventas del periodo: <?php echo $fecha1." - ".$fecha2; ?>'
      },
      {
        extend:     'pdfHtml5',
        text:       '<i class="material-icons-outlined"><img src="https://img.icons8.com/material/24/000000/pdf-2--v1.png"/></i>',
        titleAttr:  'Exportar a PDF',
        className:  'btn-flat red',
        title: 			'Reporte de ventas del periodo: <?php echo $fecha1." - ".$fecha2; ?>'
      },
      {
        extend:     'print',
        text:       '<i class="material-icons-outlined">print</i>',
        titleAttr:  'Imprimir',
        className:  'btn-flat blue',
        title: 			'<span style="font-size:18"><b>Reporte del ventas del periodo:</b> <?php echo $fecha1." - ".$fecha2;?> </span>'
      }
    ]
    });
})
</script>