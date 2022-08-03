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
  <link rel="icon" type="image/x-icon" href="img/logo.ico" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" >
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


  <link rel="stylesheet" type="text/css" href="css/index.css">
  <!-- <link rel="stylesheet" type="text/css" href="css/datatable.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="css/materialize.css"> -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- <script src="js/materialize.js"></script> -->
  <!-- <script src="js/datatable.js"></script> -->

  <!-- Datatables CDN downloaded -->
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css"/>
<link rel="stylesheet" type="text/css" href="css/buttons.dataTables.css"/>
<link rel="stylesheet" type="text/css" href="css/sidebar.css">
<script type="text/javascript" src="js/jszip.js"></script>
<script type="text/javascript" src="js/pdfmake.js"></script>
<script type="text/javascript" src="js/vfs_fonts.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/dataTables.buttons.js"></script>
<script type="text/javascript" src="js/buttons.html5.js"></script>
<script type="text/javascript" src="js/buttons.print.js"></script>
<script type="text/javascript" src="js/bootstrapGrawl.js"></script>

<title>BioEsencia - Carmina</title>
<style>

@import url('https://fonts.googleapis.com/css?family=Rubik&display=swap');
.content-table{
  border-collapse: collapse;
  margin: 25px 0;
  font-size: 0.9em;
  min-width: 400px;
  border-radius: 5px 5px 00;
  overflow: hidden;
  box-shadow: 10px 10px 8px #888888;
  /*border-top-width: 3px;*/
  /*border-top-style: solid;*/
}
.content-table thead tr{
  background-color: #009879;
  color: #FFF;
  text-align: left;
}
.content-table th, .content-table td{
  /*padding: 12px 15px !important;*/
}
.content-table tbody tr{
  border-bottom: 1px solid #dddddd;
}
.content-table tbody tr:last-of-type td{
  border-bottom: 3px solid #00aa79 !important;
}
/*TABLAS DE INICIO*/
.tabla1 thead tr{
  background-color: #e84118;
}
.tabla1 tbody tr:last-of-type td{
  border-bottom: 3px solid #e84118 !important;
}
.tabla2 thead tr{
  background-color: #fbc531;
}
.tabla2 tbody tr:last-of-type td{
  border-bottom: 3px solid #fbc531 !important;
}

::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  /*color: #919191;*/
  /*opacity: 1; /* Firefox */*/
}
#titulo1{
	/*font-family: Matura MT Script Capitals;*/
/*	font-family: Homestead Display;
	color: #ffffff;*/
}
.fuente{
  font-family: Segoe UI Light;
}
body {
  font-family: 'Rubik';
  /*overflow-x: hidden;*/
}
#cuerpo{
  overflow-x: hidden;
}
/*@media only screen and (max-width: 1000px) {
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
}*/

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

#table_ini_1 tbody th, #table_ini_1 tbody td, #table_ini_2 tbody th, #table_ini_2 tbody td{
  padding: 0;
}
.accordion-item{
  border:  none;
}

</style>
</head>

<body>
<!-- BOOTSTRAP SIDEBAR -->
<div class="d-flex">
  <div id="sidebar-container" class="bg-primary">
    <div class="logo">
      <h4 class="text-light font-weight-bold">BioEsencia</h4>
    </div>
    <div class="menu">
      <span class="txt-align"><a href="#!" class="d-block p-3 text-light" onclick="location.reload();"><i class="inline-icon material-icons-outlined me-2 lead">home</i>Inicio</a></span>
      <span class="txt-align"><a href="#!" class="d-block p-3 text-light" <?php if ($_SESSION['rol'] == 2) {echo 'hidden';}?> onclick="cargar(event, 'templates/usuarios/a_usuarios');"><i class="inline-icon material-icons-outlined me-2 lead">person</i>Usuarios</a></span>
      <a href="#!" class="d-block p-3 text-light" onclick="cargar(event, 'templates/lider-experta/a_lider-experta');"><i class="inline-icon material-icons-outlined me-2 lead">hail</i>Clientes</a>
      
      <!-- <a href="#!" class="d-block p-3 text-light" onclick="cargar(event, 'templates/productos/productos');"><i class="inline-icon material-icons-outlined me-2 lead">brush</i>Productos</a> -->
      <!-- Productos acordión -->
      <div class="accordion accordion-flush" id="accordionFlushExample">
        <div  class="accordion-item">
          <h2  class="accordion-header" id="flush-headingCero">
            <button style="background-color: #34495e;" class="accordion-button collapsed text-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCero" aria-expanded="false" aria-controls="flush-collapseCero">
              <i class="inline-icon material-icons-outlined me-2 lead">brush</i>Productos
            </button>
          </h2>
          <div id="flush-collapseCero" class="accordion-collapse collapse" aria-labelledby="flush-headingCero" data-bs-parent="#accordionFlushExample">
            <div style="background-color: #786fa6;" class="accordion-body">
              <a class="d-block border-bottom border-top p-3 text-light" href="#!" onclick='cargar(event, "templates/productos/productos");'>Productos activos</a>
              <a class="d-block border-bottom p-3 text-light" href="#!" onclick="cargar(event, 'templates/productos/productos_eliminados');">Productos eliminados</a>
            </div>
          </div>
        </div>
      <!-- Fin acordión productos -->

      <!-- compras y ventas acordion -->
      <div <?php if ($_SESSION['rol'] == 2) {echo 'hidden';}?> class="accordion accordion-flush"  id="accordionFlushExample">
        <div  class="accordion-item">
          <h2  class="accordion-header" id="flush-headingOne">
            <button style="background-color: #34495e;" class="accordion-button collapsed text-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
              <i class="inline-icon material-icons-outlined me-2 lead">local_grocery_store</i>Compras
            </button>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div style="background-color: #786fa6;" class="accordion-body">
              <a class="d-block border-bottom border-top p-3 text-light" href="#!" onclick='cargar_v("templates/compras/a_compras.php");'>Realizar compra</a>
              <a class="d-block border-bottom p-3 text-light" href="#!" onclick="cargar_v('templates/compras/reg_compras.php?ges=<?php echo date('Y') ?>');">Registro de compras</a>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item" <?php if ($_SESSION['rol'] == 2) {echo 'hidden';}?>>
        <h2 class="accordion-header" id="flush-headingTwo">
          <button style="background-color: #34495e;" class="accordion-button collapsed text-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
            <i class="inline-icon material-icons-outlined me-2 lead">shopify</i>Ventas
          </button>
        </h2>
        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
          <div style="background-color: #786fa6;" class="accordion-body">
            <!-- aqui va el contenido del acordion de compras -->
            <a style="" class="d-block border-bottom border-top p-3 text-light" href="#!" onclick="cargar_v('templates/ventas/a_ventas.php');">Realizar venta</a>
            <a style="" class="d-block border-bottom p-3 text-light" href="#!" onclick="cargar_v('templates/ventas/reg_ventas.php?ges=<?php echo date('Y') ?>');">Registro de ventas</a>
          </div>
        </div>
      </div>

      <div class="accordion-item" <?php if ($_SESSION['rol'] == 2) {echo 'hidden';}?>>
        <h2 class="accordion-header" id="flush-headingThree">
          <button style="background-color: #34495e;" class="accordion-button collapsed text-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
            <i class="inline-icon material-icons-outlined me-2 lead">shopping_cart</i>Pedidos
          </button>
        </h2>
        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
          <div style="background-color: #786fa6;" class="accordion-body">
            <a style="" class="d-block border-bottom border-top p-3 text-light" href="#!" onclick="cargar_v('templates/pedidos/pedidos.php');">Pendientes</a>
            <a style="" class="d-block border-bottom p-3 text-light" href="#!" onclick="cargar_v('templates/pedidos/reg_pedidos.php');">Aceptados</a>
          </div>
        </div>
      </div>
    </div>
      <!-- fin compras y ventas acordion -->
      <a href="#!" class="d-block p-3 text-light" onclick="cargar(event, 'templates/inventarios/a_inventarios.php');"><i class="inline-icon material-icons-outlined me-2 lead">inventory_2</i>Inventario</a>
      <a href="#!" class="d-block p-3 text-light" <?php if ($_SESSION['rol'] == 2) {echo 'hidden';}?> onclick="cargar(event, 'templates/reportes/sel_fecha');"><i class="inline-icon material-icons-outlined me-2 lead">summarize</i>Reportes</a>
    </div>
  </div>
  <!-- FIN bootstrap sidebar -->
  <div id="navbar_bootstrap" class="w-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <div class="container-fluid">
        <!-- <a class="navbar-brand" href="#">Bio Esencia</a> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
     
            <img align="center" width="40px" src="img/divisas2.png" alt="">
            <input style="width: 50px" placeholder="valor del peso en Bs." id="valor" value="0.05" type="text">
          
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

           
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Opciones
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#"><?php echo $estado; ?></a></li>
                <li><a class="dropdown-item" href="recursos/salir.php">Salir </a></li>
                <li><hr class="dropdown-divider"></li>

              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav> 

    
    <section class="py-3">
      <div class="container-fluid">
        <div id="cuerpo">
          <div class="row">
            <div class="col-md-6">
              <div class="fuente col-md-12">
                <h3>Productos escasos o agotados</h3><br>
              </div>

              <div class="col-md-12">
                <table id="table_ini_1" class="datatable tabla1 table content-table table-hover">
                  <thead>
                    <tr>
                      <th>Código <br> (Producto)</th>
                      <th>Linea</th>
                      <th>Descripción</th>
                      <th>Cantidad</th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php foreach($fila as $a  => $valor){ ?>
                    <tr>
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
          <div class="col-md-6">
              <div class="fuente col-md-12"><h3>Productos Próximos a Vencer</h3></div><br>

              <div class="col-md-12">
              <table id="table_ini_2" class="datatable tabla2 table content-table table-hover">
                <thead>
                  <tr>
                    <th>Código <br> (Producto)</th>
                    <th>Linea</th>
                    <th>Descripción</th>
                    <th>Fecha de <br>Vencimiento</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($fila2 as $a  => $valor){ ?>
                  <tr >
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
      </div>
    </section>
  </div>
</div>

<!-- Bootstrap toast -->
<div aria-live="polite" aria-atomic="true" class="position-relative">
  <!-- Position it: -->
  <!-- - `.toast-container` for spacing between toasts -->
  <!-- - `.position-absolute`, `top-0` & `end-0` to position the toasts in the upper right corner -->
  <!-- - `.p-3` to prevent the toasts from sticking to the edge of the container  -->
  <div class="toast-container position-absolute top-0 end-0 p-3">
    <div id="atoast" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div id="btoast" class="toast-body">
          Hello, world! This is a toast message.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

$(document).ready(function() {
    $('.datatable').dataTable({
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


});

function mtoast(text, color) {
  //info = azul, danger = rojo, success = verde
  $(".bootstrap-growl").remove()
  $.bootstrapGrowl(text,{
          type: color,
          delay: 4000,
          allow_dismiss: true
        })
}

  function cargar(e, x){

    if(x.includes("templates/inventarios")){
      $("#cuerpo").load(x);
    }else{
    var y=".php";
          $("#cuerpo").load(x+y);
        }
  }
  //PARA CARGAR LAS VENTAS 
  function cargar_v(x){
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