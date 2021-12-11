<?php 
require("../../recursos/sesiones.php");
require("../../recursos/conexion.php");
session_start();

$gestion = $_GET['ges'];
$periodo = $_GET['per'];

if ($periodo == 0) {
	$periodo = "";
}
$result = $conexion->query("SELECT a.ca, b.nombre, b.apellidos, SUM(a.total) AS monto FROM ventas a, clientes b WHERE a.fecha LIKE '".$gestion."-".$periodo."%' AND a.ca = b.CA AND a.estado = 1 GROUP BY a.ca");

	if((mysqli_num_rows($result))>0){
	  while($arr = $result->fetch_array()){ 
	        $fila[] = array('ca'=>$arr['ca'], 'nombre'=>$arr['nombre'], 'apellidos'=>$arr['apellidos'], 'monto'=>$arr['monto']); 
	  }
	}else{
	        $fila[] = array('ca'=>'--', 'nombre'=>'--', 'apellidos'=>'--', 'monto'=>'--');
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
<h3 class="fuente">Reporte de Lider/Experta</h3><br>
<div class="row">
	<div class="col s11">
		<table id="tabla1">
			<thead>
				<tr>
					<th>Código Arbell</th>
					<th>Nombres y apellidos</th>
					<th>Valor de compras en Bs.</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($fila as $a  => $valor){ ?>
				<tr>
					<td><?php echo $valor['ca']?></td>
					<td><?php echo $valor['nombre']." ".$valor['apellidos']?></td>
					<td><?php echo round(((float)$valor['monto']), 1)?></td>
				</tr>
			    <?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	    
$(document).ready(function() {
	$('#tabla1').dataTable({
      "order": [[ 2, "desc" ]],
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
        title: 			'Reporte de lider/experta del periodo: <?php if ($periodo == '0') {echo $gestion;}else{echo $gestion."-".$periodo;} ?>'
      },
      {
        extend:     'pdfHtml5',
        text:       '<i class="material-icons-outlined"><img src="https://img.icons8.com/material/24/000000/pdf-2--v1.png"/></i>',
        titleAttr:  'Exportar a PDF',
        className:  'btn-flat red',
        title: 			'Reporte de lider/experta del periodo: <?php if ($periodo == '0') {echo $gestion;}else{echo $gestion."-".$periodo;} ?>'
      },
      {
        extend:     'print',
        text:       '<i class="material-icons-outlined">print</i>',
        titleAttr:  'Imprimir',
        className:  'btn-flat blue',
        title: 			'<span style="font-size:30">Reporte del lider/experta de periodo: <?php if ($periodo == '0') {echo $gestion;}else{echo $gestion."-".$periodo;} ?> </span>'
      }
    ]
    });
})
</script>