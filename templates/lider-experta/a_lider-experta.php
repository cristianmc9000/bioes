<?php
//Comentario para ver en git
require('../../recursos/conexion.php');

$_SESSION['filas'] = array(); 
$Sql = "SELECT * FROM clientes WHERE estado=1"; 
$Busq = $conexion->query($Sql); 
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('id'=>$arr['id'], 'ca'=>$arr['CA'], 'ci'=>$arr['CI'], 'nombre'=>$arr['nombre'], 'apellidos'=>$arr['apellidos'], 'telefono'=>$arr['telefono'], 'lugar'=>$arr['lugar'], 'correo'=>$arr['correo'], 'fecha_alta'=>$arr['fecha_alta'], 'nivel'=>$arr['nivel']); 
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <title>Clientes</title>
<style>

  table.dataTable tbody th, table.dataTable tbody td {
    padding: 1px 0px;
  }

  table.highlight > tbody > tr:hover {
    background-color: #a0aaf0 !important;
  }
/*
  #tabla1{
    border-collapse: separate;
    border-radius: 5px;
    border-spacing: 1px;
    border: solid;
    border-color: #1f1f1f;
  }
*/

</style>

</head>
<body>
<div class="row">
<div class="col s11">

<span class="fuente">
  <h3>Nueva Lider/Experta 
    <!-- Modal Trigger -->
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modal1"><i  class="material-icons align-middle">add</i>Agregar</button>
    
</h3> 
</span>

<!-- TABLA -->
<div class="row">
  <div class="col-md-11">
    <table id="tabla1" class="content-table table table-hover">
        <thead>
          <tr>
              <th>Codigo arbell</th>
              <th>CI</th>
              <th>Nombre</th>
              <th>Apellidos</th>
              <th>Teléfono</th>
              <th>Lugar</th>
              <th>Correo</th>
              <th>Fecha alta</th>
              <th>Nivel</th>
              <th>Modificar</th>
              <th>Borrar</th>
              <th>Ver</th>
              <!--<th data-field="price">Ver Cliente</th>-->
          </tr>
        </thead>
        <tbody>
        <?php foreach($fila as $a  => $valor){ ?>
          <tr>
            <td><?php echo $valor["ca"] ?></td>
            <td><?php echo $valor["ci"] ?></td>
            <td><?php echo $valor["nombre"] ?></td>
            <td><?php echo $valor["apellidos"] ?></td>
            <td><?php echo $valor["telefono"] ?></td>
            <td width="8%"><?php echo $valor["lugar"] ?></td>
            <td><?php echo $valor["correo"] ?></td>
            <td><?php echo $valor["fecha_alta"] ?></td>
            <td><?php echo $valor["nivel"] ?></td>
       
            <td><a href="#!" onclick="mod_cliente('<?php echo $valor['id'] ?>', '<?php echo $valor['ca'] ?>','<?php echo $valor['ci'] ?>','<?php echo $valor['nombre'] ?>','<?php echo $valor['apellidos'] ?>', '<?php echo $valor['telefono'] ?>', '<?php echo $valor['lugar'] ?>','<?php echo $valor['correo'] ?>','<?php echo $valor['nivel'] ?>','<?php echo $valor['fecha_alta'] ?>');">
            <i class="material-icons">build</i></a></td>
            <!--HASTA AQUI-->
            <td><a href="#!" onclick="borrar_cliente('<?php echo $valor['id'] ?>');"><i class="material-icons">delete</i></a></td>
            <td><a href="#"><i class="material-icons">search</i></a></td>
          </tr>
        <?php } ?> 
        </tbody>
    </table>
  </div>
</div>

<!-- TERMINAR MODAL AGREGAR CLIENTE -->
<!--MODAL AGREGAR CLIENTE-->
<div id="modal1" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title">Agregar Lider/Experta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="agregar_cliente">
            <div class="row g-3">
              <div class="col-sm-12 col-md-6">
                <label class="form-label small text-muted" for="ca">* Codigo arbell</label>
                <input name="ca" type="number" class="form-control" required>
              </div>

              <div class="col-sm-12 col-md-6">
                <label class="form-label small text-muted" for="nombre">* Nombre:</label>
                <input name="nombre" type="text" class="form-control" required>
              </div>

              <div class="col-sm-12 col-md-6">
                <label class="form-label small text-muted" for="apellidos">* Apellidos:</label>
                <input name="apellidos" type="text" class="form-control" required>
              </div>

              <div class="col-sm-12 col-md-6">
                <label class="form-label small text-muted" for="ci">* CI:</label>
                <input name="ci" type="number" class="form-control" required>
              </div>

            <div  class="col-sm-12 col-md-6">
              <label class="form-label small text-muted" for="telefono">* Teléfono: </label>
              <input name="telefono" class="form-control" type="number" required>
            </div>

              <div class="col-sm-12 col-md-6">
                <label class="form-label small text-muted" for="lugar">* Lugar:</label>
                <input name="lugar" type="text" class="form-control" required>
              </div>

              <div class="col-sm-12 col-md-6">
                <label class="form-label small text-muted" for="correo">* Correo: </label>
                <input name="correo" type="email" class="form-control" required>
              </div>

              <div class="col-sm-12 col-md-6">
                  <label class="form-label small text-muted" for="fecha_alta">* Fecha de alta:</label>
                  <input name="fecha_alta" id="fecha_alta" type="date" value="" class="form-control" required>
              </div>

              <div class="col-sm-12">
                <div class="input-group mb-1">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Nivel</label>
                  </div>
                  <select name="nivel" class="form-select" id="inputGroupSelect01">
                    <option value="1" selected>Experta</option>
                    <option value="2">Lider</option>
                  </select>
                </div>
              </div> 

            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button form="agregar_cliente" type="submit" class="btn btn-primary" type="submit" >Aceptar</button>
      </div>
    </div>
  </div>
</div>


<!--MODAL MODIFICAR CLIENTE-->
<div class="row">
<div id="modal3" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4>Modificar cliente</h4>  
    <div class="row">
      <form id="modificar_cliente" class="col s12" >

          <div class="row">
            <div id="ca" class="input-field col s6"></div>
            <div id="nombre" class="input-field col s6"></div>
          </div>
          <div class="row">  
            <div id="apellidos" class="input-field col s6"></div>
            <div id="ci" class="input-field col s6"></div>
          </div>
          <div class="row">
            <div id="telefono" class="input-field col s6"></div>
            <div id="lugar" class="input-field col s6"></div>
          </div>
          <div class="row">  
            <div id="correo" class="input-field col s6"></div>
            <div id="tipo" class="input-field col s6"></div>
            <!-- DATOS ANTERIORES -->
            <div class="input-field col s6" id="datos_anteriores"></div>
            <!-- FIN DATOS ANTERIORES -->
          </div>
          <div class="row">
              <div class="input-field col s6">
                  <input name="fecha_alta_mod" id="fecha_alta_mod" type="date" value="" class="validate" required>
                  <label class="active" for="fecha_alta_mod">Fecha de alta:</label>
              </div>
          </div>
          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
          </div>
      </form>
    </div>
  </div>
</div>
</div>

<!--MODAL BORRAR CLIENTE-->
<div class="row">
<div id="modal4" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4><b>Borrar Lider/Experta</b></h4>  
    <p>¿Esta seguro que desea eliminar a esta lider/experta?</p>
    <div class="row">
      <form class="col s12" id="borrar_cliente">
          <div class="row">
            <div class="input-field col s6" id="datos_borrar">
              
            </div>
          </div>

          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
          </div>
      </form>
    </div>
  </div>
</div>
</div>


<!--PARA RECIBIR MENSAJES DESDE PHP-->  
    <div id="mensaje"></div>

<script>
$(document).ready(function() {
    $('#tabla1').dataTable({
      "order": [[ 0, "desc" ]],
      "language": {
      "lengthMenu": "Registros por página: _MENU_",
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

    let today = new Date().toISOString().slice(0, 10)
    document.getElementById('fecha_alta').value = today

});
var mensaje = $("#mensaje");
mensaje.hide();

function mod_cliente(id,ca, ci, nombre, apellidos, telefono, lugar, correo, tipo, fecha_alta){

  document.getElementById("ca").innerHTML ='<input name="ca" type="number" class="validate" value="'+ca+'"><label for="ca" class="active">Código Arbell:</label>';
  document.getElementById("ci").innerHTML ='<input name="ci" type="number" class="validate" value="'+ci+'"><label for="ci" class="active">CI:</label>';
  document.getElementById("nombre").innerHTML ='<input name="nombre" type="text" class="validate" value="'+nombre+'"><label for="nombre" class="active">Nombres: </label>';
  document.getElementById("apellidos").innerHTML ='<input name="apellidos" type="text" class="validate" value="'+apellidos+'"><label for="apellidos" class="active">Apellidos: </label>';
  document.getElementById("telefono").innerHTML ='<input name="telefono" type="number" class="validate" value="'+telefono+'"><label for="telefono" class="active">Teléfono: </label>';
  document.getElementById("lugar").innerHTML ='<input name="lugar" type="text" class="validate" value="'+lugar+'"><label for="lugar" class="active">Lugar: </label>';
  document.getElementById("correo").innerHTML ='<input name="correo" type="email" class="validate" value="'+correo+'"><label for="correo" class="active">Correo: </label>';

sel1 = ''
sel2 = ''

 if(tipo == 'experta'){
  sel1 = 'selected'
 }else{
  sel2 = 'selected'
 }

  $("#tipo").html('<select class="browser-default" name="nivel"><option value="1" '+sel1+'>Experta</option><option value="2" '+sel2+'>Lider</option></select>');

  $("#fecha_alta_mod").val(fecha_alta)

$("#datos_anteriores").html('<input name="ca_ant" type="text" value="'+ca+'" hidden><input name="ci_ant" type="text" value="'+ci+'" hidden><input name="id" type="text" value="'+id+'" hidden>');

  $('#modal3').openModal();
}
$("#modificar_cliente").on("submit", function(e){
    e.preventDefault();

    var val = new FormData(document.getElementById("modificar_cliente"));
    $.ajax({
      url: "recursos/lider-experta/modcliente.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
    	mensaje.html(echo);
      if (echo.includes('success')) {
        $("#modal3").closeModal()
        Materialize.toast("Datos de lider/experta modificados.", 4000)
        $("#cuerpo").load("templates/lider-experta/a_lider-experta.php");
      }
    });
});

function borrar_cliente(id){

  document.getElementById("datos_borrar").innerHTML ='<input type="text" name="id" value="'+id+'" hidden/>';
  $('#modal4').openModal();
}
$("#borrar_cliente").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("borrar_cliente"));
    $.ajax({
      url: "recursos/lider-experta/borrarcliente.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("templates/lider-experta/a_lider-experta.php");      
      }
    });
});

$("#agregar_cliente").on("submit", function(e){
    e.preventDefault();
    console.log("llego")
    var val = new FormData(document.getElementById("agregar_cliente"));
    $.ajax({
      url: "recursos/lider-experta/clientes.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
    	// mensaje.html(echo)
      console.log(echo)
      if (echo.includes('reg')){
      	Materialize.toast('<b>'+echo+'</b>', 4000)
      	$("#modal1").closeModal()
        $("#cuerpo").load("templates/lider-experta/a_lider-experta.php");   
      }
    });
});

  // $(document).ready(function() {
  //   $('select').material_select();
  // });
</script>

</div>
</div>
</body>
</html>