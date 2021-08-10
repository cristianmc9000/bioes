<?php
require('recursos/sesiones.php');
require('recursos/conexion.php');
session_start();
date_default_timezone_set("America/La_Paz");
$fecha = date('Y-m-d');
$fecha = date ('Y-m-d', strtotime($fecha.'+ 3 month'));

//Comprobamos si el usario está logueado
//Si no lo está, se le redirecciona al index
//Si lo está, definimos el botón de cerrar sesión y la duración de la sesión
if(!isset($_SESSION['usuario']) and $_SESSION['estado'] != 'Autenticado') {
	header('Location: index.php');
} else {
	$estado = $_SESSION['usuario'];
  $ciactual = $_SESSION['userCI']; 
	$salir = '<a href="recursos/salir.php" class="right" target="_self">Cerrar sesión</a>';
};

//consulta para inicio
$Sql = "SELECT a.id, d.nombre, a.descripcion, c.cantidad FROM productos a,   invcant c, lineas d WHERE a.id=c.codp AND a.linea = d.codli AND c.cantidad < 51"; 
$Busq = $conexion->query($Sql); 
if((mysqli_num_rows($Busq))>0){
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('id'=>$arr['id'],'linea'=>$arr['nombre'], 'descripcion'=>$arr['descripcion'],'cantidad'=>$arr['cantidad']); 
    }}else{
  $fila[] = array('id'=>'--', 'linea'=>'--', 'descripcion'=>'--', 'cantidad'=>'--');
    }

  /* consulta fecha de vencimiento */
  $Sql2 = "SELECT b.codp, d.nombre, a.descripcion, b.fecha_venc FROM productos a, inventario b, lineas d WHERE b.estado = 1 AND a.linea = d.codli AND b.codp = a.id AND b.fecha_venc < '".$fecha."' AND b.fecha_venc > '0000-00-00'";
$Busq2 = $conexion->query($Sql2); 
if((mysqli_num_rows($Busq2))>0){
while($arr = $Busq2->fetch_array()) 
    { 
        $fila2[] = array('id'=>$arr['codp'],'linea'=>$arr['nombre'], 'descripcion'=>$arr['descripcion'],'fecha'=>$arr['fecha_venc']); 
    }}else{
  $fila2[] = array('id'=>'--', 'linea'=>'--', 'descripcion'=>'--', 'fecha'=>'--');
}
?>
<!DOCTYPE html>
<html lang="ES">
<head>
<meta charset="utf-8">
  <link rel="icon" type="image/x-icon" href="img/iconoarbell.ico" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" >
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <!-- <link rel="stylesheet" type="text/css" href="css/datatable.css"> -->
  <link rel="stylesheet" type="text/css" href="css/materialize.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="js/materialize.js"></script>
  <!-- <script src="js/datatable.js"></script> -->

  <!-- Datatables CDN downloaded -->
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css"/>
<link rel="stylesheet" type="text/css" href="css/buttons.dataTables.css"/>
 
<script type="text/javascript" src="js/jszip.js"></script>
<script type="text/javascript" src="js/pdfmake.js"></script>
<script type="text/javascript" src="js/vfs_fonts.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/dataTables.buttons.js"></script>
<script type="text/javascript" src="js/buttons.html5.js"></script>
<script type="text/javascript" src="js/buttons.print.js"></script>

<title>Arbell</title>
<style>
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #919191;
  opacity: 1; /* Firefox */
}
#titulo1{
	/*font-family: Matura MT Script Capitals;*/
	font-family: Homestead Display;
	color: #ffffff;
}
.fuente{
  font-family: Segoe UI Light;
}
@media only screen and (max-width: 1000px) {
	  #titulo1{
	  	display: none;
	  }
    #imprimir{
      display:none;
    }
}
@media only screen and (max-width: 1300px) {
	  #titulo2{
	  	display: none;
	  }
}
.color-nav{
  background-color: #1abc9c;
}
nav ul a:hover {
  background-color: rgba(0, 0, 0, 0.3) !important;
}
nav ul li a:hover {
  background-color: rgba(c, c, 0, 0.3) !important;
}

.embed-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
}
.embed-container iframe {
    position: absolute;
    top:0;
    left: 0;
    width: 100%;
    height: 100%;
}
table.highlight > tbody > tr:hover {
  background-color: #a0aaf0 !important;
}
.color-amarillo{
  background-color:  #FFFF01 !important;
}
.color-rojo{
  background-color: #FFBBBB !important;
}
.divisas{
    width: 100%;
    height: auto;
    object-fit: cover;
}
table.dataTable tbody th, table.dataTable tbody td {
    padding: 5px 5px;
}
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
</head>

<body>
<ul id="dropdown1" class="dropdown-content">
  <!--<li><a href="#!" onclick="cargar('eliminados');">Productos Activos</a></li>-->
  <li><a href="#!" onclick="cargar('art_eliminados');">Productos Eliminados</a></li>
</ul>

<nav class="color-nav">
  <div class="nav-wrapper" >
    <ul class="right hide-on-med-and-down">
      <li><img align="center" width="40px" src="img/divisas2.png" alt=""></li>
      <li><input style="width: 40px" placeholder="valor del peso en Bs." id="valor" value="0.07" type="text"></li>
      <li><?php echo $estado; ?></li>
      <li><?php echo $salir; ?></li>
    </ul>

    <ul id="dropdown1" class="dropdown-content">
      <li><a href="#!" onclick="cargar_v(event, 'templates/ventas/a_ventas.php');">Realizar venta</a></li>
      <li><a href="#!" onclick="cargar_v(event, 'templates/ventas/reg_ventas.php?ges=<?php echo date('Y') ?>');">Registro de ventas</a></li>
    </ul>
    <ul id="dropdown2" class="dropdown-content">
      <li><a href="#!" onclick="cargar_v(event, 'templates/compras/a_compras.php');">Realizar compra</a></li>
      <li><a href="#!" onclick="cargar_v(event, 'templates/compras/reg_compras.php?ges=<?php echo date('Y') ?>');">Registro de compras</a></li>
    </ul>

    <ul id="nav-mobile" class="left hide-on-med-and-down">
        <li><a href="#!" onclick="location.reload();">INICIO</a></li>
        <li <?php if ($_SESSION['rol'] == 2) {echo 'hidden';}?>><a href="#!" onclick="cargar(event, 'templates/usuarios/a_usuarios');">USUARIOS</a></li>
        <li><a href="#!" onclick="cargar(event, 'templates/lider-experta/a_lider-experta');">LIDER/EXPERTA</a></li>
        <li><a href="#!" onclick="cargar(event, 'templates/productos/a_prod-periodos');">PRODUCTOS</a></li>
        <!--  <li><a href="#!" onclick="cargar(event, 'templates/roles/a_roles');">ROLES</a></li> -->
        <li <?php if ($_SESSION['rol'] == 2) {echo 'hidden';}?>>
          <a class="dropdown-button" data-beloworigin="true" href="#!" data-activates="dropdown2">COMPRAS<i class="material-icons right">arrow_drop_down</i></a>
        </li>
        <li>
          <a class="dropdown-button" data-beloworigin="true" href="#!" data-activates="dropdown1">VENTAS<i class="material-icons right">arrow_drop_down</i></a>
        </li>
        

        <li><a href="#!" onclick="cargar(event, 'templates/inventarios/a_inventarios.php');">INVENTARIO</a></li>
        
        <li <?php if ($_SESSION['rol'] == 2) {echo 'hidden';}?>><a href="#!" onclick="cargar(event, 'templates/reportes/sel_fecha');">REPORTES</a></li>
        <li class="brand-logo"></li>        
      </ul>
      <a href="#!" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

    <ul class="side-nav" id="mobile-demo">
      <li><?php echo $estado, $ciUSER; ?></li>
      <li><a href="#!" onclick="location.reload();">INICIO</a></li>
      <li><a href="#!" onclick="cargar('productos');">Ventas</a></li>
      <li><a href="#!" onclick="cargar('inventario');">Productos</a></li>
      <li><a href="#!" onclick="cargar('clientes');">Clientes</a></li>
      <li><a href="#!" onclick="cargar('sel_fecha');">Registro de ventas</a></li>
      <li><a href="#!" onclick="cargar('Prod_vendidos');">Prod. Vendidos</a></li>
      <!--<li><a href="#!" onclick="cargar('reportes');">Reportes</a></li>-->
      <li><?php echo $salir; ?></li>
    </ul>
    </div>
</nav>

<div class="row">
    <div id="cuerpo" class="col s12">
      <div class="col s6">
        <span class="fuente col s12">
          <div class="col s12"><h3>Productos escasos</h3></div><br>
        </span>
          <!-- TABLA -->
          <div class="col s11">
          <table id="" class="tabla1 highlight">
            <thead>
              <tr>
                <th>Código <br> (Producto)</th>
                <th>Linea</th>
                <th>Descripción</th>
                <th>Cantidad</th>
              </tr>
            </thead>
            <!--  -->
            <tbody>
            <?php foreach($fila as $a  => $valor){ ?>
              <tr style="background-color: #F78181">
                <td><?php echo $valor["id"] ?></td>
                <td><?php echo $valor["linea"] ?></td>
                <td><?php echo $valor["descripcion"] ?></td>
                <td><?php echo $valor["cantidad"] ?></td>
              </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- tabla fechas -->
      <div class="col s6">
        <span class="fuente col s12">
          <div class="col s12"><h3>Productos Próximos a Vencer</h3></div><br>
        </span>
          <!-- TABLA -->
          <div class="col s11">
          <table id="" class="tabla1 highlight">
            <thead>
              <tr>
                <th>Código <br> (Producto)</th>
                <th>Linea</th>
                <th>Descripción</th>
                <th>Fecha de <br>Vencimiento</th>
              </tr>
            </thead>
            <!--  -->
            <tbody>
            <?php foreach($fila2 as $a  => $valor){ ?>
              <tr style="background-color: #FFFF00">
                <td><?php echo $valor["id"] ?></td>
                <td><?php echo $valor["linea"] ?></td>
                <td><?php echo $valor["descripcion"] ?></td>
                <td><?php echo $valor["fecha"] ?></td>
              </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
</div>


<script type="text/javascript">

$(document).ready(function() {
    $('.tabla1').dataTable({
        "order": [[ 0, "desc" ]],
        "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "Lo siento, no se encontraron datos",
        "info": "Página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay datos disponibles",
        "infoFiltered": "(filtrado de _MAX_ resultados)",
        "paginate": {
          "next": "Siguiente",
          "previous": "Anterior"
        }
        }
    });

  $(".dropdown-button").dropdown({ hover: true, beloworigin: true });
  $(".button-collapse").sideNav();

});

  function cargar(e, x){

    for (var i = 1; i <= 8; i++) {
      // console.log(e.target.parentNode.parentNode.children[i])
      e.target.parentNode.parentNode.children[i].style.backgroundColor = "#1abc9c"
    }

    e.target.parentNode.style.backgroundColor = "#3498db"

    if(x.includes("templates/inventarios")){
      $("#cuerpo").load(x);
    }else{
    var y=".php";
          $("#cuerpo").load(x+y);
        }
  }
  //PARA CARGAR LAS VENTAS 
  function cargar_v(e, x){
    for (var i = 1; i <= 8; i++) {
      e.target.parentNode.parentNode.parentNode.parentNode.children[i].style.backgroundColor = "#1abc9c"
    }
    e.target.parentNode.parentNode.parentNode.style.backgroundColor = "#3498db"
    $("#cuerpo").load(x);
        
  }


function check(e){
  if ((e.charCode >= 48 && e.charCode <= 57) || e.charCode == 46) {
    return true
  }else{
    return false
  }
}

</script>
        
</body>

</html>