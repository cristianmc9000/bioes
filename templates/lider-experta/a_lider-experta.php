<?php
//Comentario para ver en git
require('../../recursos/conexion.php');

$_SESSION['filas'] = array(); 
$Sql = "SELECT * FROM clientes WHERE estado=1"; 
$Busq = $conexion->query($Sql); 
$fila = $Busq->fetch_all(MYSQLI_ASSOC);
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

.ui-autocomplete-row {
    padding: 8px;
    background-color: #f4f4f4;
    border-bottom: 1px solid #ccc;
    font-weight: bold;
}

.ui-autocomplete-row:hover {
    background-color: #ddd;
}


.ui-menu{
  z-index: 9999;
}
</style>

</head>
<body>
<div class="row">
<div class="col s11">

<span class="fuente">
  <h3>Nueva Cliente 
    <!-- Modal Trigger -->
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modal1"><i  class="material-icons align-middle">add</i>Agregar</button>
    
</h3> 
</span>

<!-- TABLA -->
<div class="row">
  <div class="col-md-11">
    <table id="tabla1" class="content-table table table-hover text-center">
        <thead >
          <tr class="text-center">
              <th>Codigo cliente</th>
              <th>CI</th>
              <th>Nombre</th>
              <th>Apellidos</th>
              <th>Teléfono</th>
              <th>Lugar</th>
              <th>Correo</th>

              <th>Nivel</th>
              <th>Modificar</th>
              <th>Borrar</th>
              <!-- <th>Ver</th> -->
              <!--<th data-field="price">Ver Cliente</th>-->
          </tr>
        </thead>
        <tbody>
        <?php foreach($fila as $a  => $valor){ ?>
          <tr>
            <td><?php echo $valor["CA"] ?></td>
            <td><?php echo $valor["CI"] ?></td>
            <td><?php echo $valor["nombre"] ?></td>
            <td><?php echo $valor["apellidos"] ?></td>
            <td><?php echo $valor["telefono"] ?></td>
            <td width="8%"><?php echo $valor["lugar"] ?></td>
            <td><?php echo $valor["correo"] ?></td>

            <td><?php echo $valor["nivel"] ?></td>
       
            <td><a href="#!" onclick="mod_cliente('<?php echo $valor['id'] ?>', '<?php echo $valor['CA'] ?>','<?php echo $valor['CI'] ?>','<?php echo $valor['nombre'] ?>','<?php echo $valor['apellidos'] ?>', '<?php echo $valor['telefono'] ?>', '<?php echo $valor['lugar'] ?>','<?php echo $valor['correo'] ?>','<?php echo $valor['nivel'] ?>','<?php echo $valor['lider'] ?>','<?php echo $valor['fecha_alta'] ?>');">
            <i class="material-icons">build</i></a></td>
            <!--HASTA AQUI-->
            <td><a href="#!" onclick="borrar_cliente('<?php echo $valor['id'] ?>');"><i class="material-icons">delete</i></a></td>
            <!-- <td><a href="#"><i class="material-icons">search</i></a></td> -->
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
                <label class="form-label small text-muted" for="ci">* CI:</label>
                <input id="agregar_cliente_cedula" name="ci" type="number" onkeypress="return check(event)" class="form-control" required>
              </div>

              <div class="col-sm-12 col-md-6">
                <label class="form-label small text-muted" for="ca">* Codigo cliente</label>
                <input id="agregar_cliente_codigo_hidden" name="ca" hidden>
                <input id="agregar_cliente_codigo" name="ca_" type="number" class="form-control" disabled>
              </div>

              <div class="col-sm-12 col-md-6">
                <label class="form-label small text-muted" for="nombre">* Nombre:</label>
                <input name="nombre" type="text" class="form-control" required>
              </div>

              <div class="col-sm-12 col-md-6">
                <label class="form-label small text-muted" for="apellidos">* Apellidos:</label>
                <input name="apellidos" type="text" class="form-control" required>
              </div>

              

            <div  class="col-sm-12 col-md-6">
              <label class="form-label small text-muted" for="telefono">* Teléfono: </label>
              <input name="telefono" class="form-control" type="number" onkeypress="return check(event)" required>
            </div>

              <div class="col-sm-12 col-md-6">
                <label class="form-label small text-muted" for="lugar">* Lugar:</label>
                <input name="lugar" type="text" class="form-control" required>
              </div>

              <div class="col-sm-12 col-md-6">
                <label class="form-label small text-muted" for="correo">* Correo: </label>
                <input name="correo" type="email" class="form-control" required>
              </div>

              <!-- <div class="col-sm-12 col-md-6">
                  <label class="form-label small text-muted" for="fecha_alta">* Fecha de alta:</label>
                  <input name="fecha_alta" id="fecha_alta" type="date" value="" class="form-control" required>
              </div> -->

              <div class="col-sm-12 col-md-6">
                <label class="form-label small text-muted" for="nivel">Nivel: </label>
                <select name="nivel" class="form-select" id="_nivel" onchange="mostrar_lider()">
                  <option value="1" selected>Experta</option>
                  <option value="2">Lider</option>
                </select>
              </div> 
              <div class="row g-3" id="row_seleccionar_lider">
                <div class="col-sm-10">
                  <div class="input-group mb-3">
                    <input type="text" id="id_lider" name="id_lider" value="" hidden>
                    <span class="input-group-text" id="basic-addon3">Lider a cargo</span>
                    <input type="text" class="form-control" id="search_lider" placeholder="Buscar lider" placaria-describedby="basic-addon3">
                  </div>
                </div>
                <div class="col-sm-2">
                    <!-- <div class="input-group mb-3"> -->
                      <button id="btn_eliminar_lider" type="button" class="btn btn-outline-danger ">❌</button>
                    <!-- </div> -->
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
<div id="modal3" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificar Lider/Experta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modificar_cliente">
                    <div class="row g-3">
                        <div id="ci" class="col-sm-12 col-md-6">
                          <label for="ci" class="form-label small text-muted">CI:</label>
                          <input id="mod_cliente_ci" name="ci" type="number" class="form-control" onkeypress="return check(event)" required>
                        </div>
                        <div id="ca" class="col-sm-12 col-md-6"></div>
                        
                        <div id="nombre" class="col-sm-12 col-md-6"></div>
                        <div id="apellidos" class="col-sm-12 col-md-6"></div>
                        
                        <div id="telefono" class="col-sm-12 col-md-6"></div>
                        <div id="lugar" class="col-sm-12 col-md-6"></div>

                        <div id="correo" class="col-sm-12 col-md-6"></div>
                        <!-- <div id="tipo" class="col-sm-12 col-md-6"></div> -->
                        <!-- DATOS ANTERIORES -->
                        <div class="col-sm-12 col-md-6" id="datos_anteriores" hidden></div>
                        <!-- FIN DATOS ANTERIORES -->
                        <div class="col-sm-12 col-md-6" hidden>
                            <label class="form-label small text-muted" for="fecha_alta_mod">Fecha de alta:</label>
                            <input name="fecha_alta_mod" id="fecha_alta_mod" type="date" value="" class="form-control">
                        </div>

                        <div class="col-sm-6">
                          <label class="form-label small text-muted" for="tipo">Nivel</label>
                          <select id="tipo" class="form-select" onchange="mod_mostrar_lider()" name="nivel"><option value="x"></option></select>
                        </div>

                        <div class="row g-3" id="mod_row_seleccionar_lider">
                          <div class="col-sm-10">
                            <div class="input-group mb-3">
                              <input type="text" id="mod_id_lider" name="id_lider" value="" hidden>
                              <span class="input-group-text" id="basic-addon3">Lider a cargo</span>
                              <input type="text" class="form-control" id="mod_search_lider" placeholder="Buscar líder" placaria-describedby="basic-addon3">
                            </div>
                          </div>
                          <div class="col-sm-2">
                              <!-- <div class="input-group mb-3"> -->
                                <button id="mod_btn_eliminar_lider" type="button" class="btn btn-outline-danger ">❌</button>
                              <!-- </div> -->
                          </div> 
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" form="modificar_cliente" type="submit">Aceptar</button>
            </div>
        </div>
    </div>
</div>
</div>

<!--MODAL BORRAR CLIENTE-->

<div id="modal4" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Borrar Lider/Experta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Esta seguro que desea eliminar a esta lider/experta?</p>
                <form id="borrar_cliente">
                    <div class="row g-3">
                        <div class="col-sm-12 col-md-6" id="datos_borrar"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" form="borrar_cliente" type="submit">Aceptar</button>              
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

    // let today = new Date().toISOString().slice(0, 10)
    // document.getElementById('fecha_alta').value = today

    $('#search_lider').autocomplete({
    source: "recursos/lider-experta/buscar_lider.php",
    minLength: 3,
    select: function(event, ui) {
        $('#search_lider').val(ui.item.value)
        document.getElementById('search_lider').disabled = true;
        document.getElementById('search_lider').style.color = '#7f8fa6';
        // document.getElementById('btn_eliminar_lider').hidden = false;
        document.getElementById('id_lider').value = ui.item.ca;
        // document.getElementById('search_lider').style = "background-color: #27ae60; color: white;"
        // $('#boton_agregar_lider').attr("hidden", false)
    }
    }).data('ui-autocomplete')._renderItem = function(ul, item) {
        return $("<li class='ui-autocomplete-row'></li>")
            .data("item.autocomplete", item)
            .append(item.label)
            .appendTo(ul);
    };

    $('#mod_search_lider').autocomplete({
    source: "recursos/lider-experta/buscar_lider.php",
    minLength: 1,
    select: function(event, ui) {
        $('#mod_search_lider').val(ui.item.value)
        document.getElementById('mod_search_lider').disabled = true;
        document.getElementById('mod_search_lider').style.color = '#7f8fa6';
        document.getElementById('mod_id_lider').value = ui.item.ca;
    }
    }).data('ui-autocomplete')._renderItem = function(ul, item) {
        return $("<li class='ui-autocomplete-row'></li>")
            .data("item.autocomplete", item)
            .append(item.label)
            .appendTo(ul);
    };
});
var mensaje = $("#mensaje");
mensaje.hide();


function mod_cliente(id,ca, ci, nombre, apellidos, telefono, lugar, correo, tipo, lider, fecha_alta){
  document.getElementById("mod_cliente_ci").value = ci;
  document.getElementById("ca").innerHTML ='<label for="ca" class="form-label small text-muted">Código cliente:</label><input name="ca_" type="number" class="form-control" value="'+ca+'" id="mod_cliente_ca" disabled><input type="text" name="ca" id="mod_cliente_ca_hidden" value="'+ca+'" hidden>';
  document.getElementById("nombre").innerHTML ='<label for="nombre" class="form-label small text-muted">Nombres: </label><input name="nombre" type="text" class="form-control" value="'+nombre+'">';
  document.getElementById("apellidos").innerHTML ='<label for="apellidos" class="form-label small text-muted">Apellidos: </label><input name="apellidos" type="text" class="form-control" value="'+apellidos+'">';
  document.getElementById("telefono").innerHTML ='<label for="telefono" class="form-label small text-muted">Teléfono: </label><input name="telefono" type="number" class="form-control" onkeypress="return check(event)" value="'+telefono+'">';
  document.getElementById("lugar").innerHTML ='<label for="lugar" class="form-label small text-muted">Lugar: </label><input name="lugar" type="text" class="form-control" value="'+lugar+'">';
  document.getElementById("correo").innerHTML ='<label for="correo" class="form-label small text-muted">Correo: </label><input name="correo" type="email" class="form-control" value="'+correo+'">';
  document.getElementById('mod_btn_eliminar_lider').click();

sel1 = ''
sel2 = ''

 if(tipo == 'experta'){
  document.getElementById('mod_row_seleccionar_lider').hidden = false;
  sel1 = 'selected'
 }else{
  document.getElementById('mod_row_seleccionar_lider').hidden = true;
  sel2 = 'selected'
 }

  $("#tipo").html('<option value="1" '+sel1+'>Experta</option><option value="2" '+sel2+'>Lider</option>');

  $("#fecha_alta_mod").val(fecha_alta)

$("#datos_anteriores").html('<input name="ca_ant" type="text" value="'+ca+'" hidden><input name="ci_ant" type="text" value="'+ci+'" hidden><input name="id" type="text" value="'+id+'" hidden>');


//obteniendo NOMBRE Y APELLIDOS de lider 
  fetch('recursos/lider-experta/get_lider.php?id='+lider)
  .then(response => {
    response.text().then(function(res) {
      if (res == 'nodata') {
        return $('#modal3').modal('show');
      }
      document.getElementById('mod_id_lider').value = lider;
      document.getElementById('mod_search_lider').value = res;
      document.getElementById('mod_search_lider').disabled = true;
      document.getElementById('mod_search_lider').style.color = '#7f8fa6';
      $('#modal3').modal('show');
    })
  })
}

  
$("#modificar_cliente").on("submit", function(e){
    console.log('qweqwe')
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
        $("#modal3").modal('toggle')
        mtoast("Datos de lider/experta modificados.", 'success')
        $("#cuerpo").load("templates/lider-experta/a_lider-experta.php");
      }
    });
});

function borrar_cliente(id){
  document.getElementById("datos_borrar").innerHTML ='<input type="text" name="id" value="'+id+'" hidden/>';
  $('#modal4').modal('toggle');
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
      // console.log(echo)
      if (echo.includes('reg')){
      	mtoast('<b>'+echo+'</b>', 'success')
      	$("#modal1").modal('toggle')
        $("#cuerpo").load("templates/lider-experta/a_lider-experta.php");   
      }else{
        mensaje.html(echo)
      }
    });
});


function mostrar_lider() {
  let nivel = document.getElementById('_nivel').value;
  if (nivel == '2') {
    document.getElementById('btn_eliminar_lider').click();
    document.getElementById('row_seleccionar_lider').hidden = true;
  }else{
    document.getElementById('row_seleccionar_lider').hidden = false;
    document.getElementById('btn_eliminar_lider').click();
  }
}

function mod_mostrar_lider() {
  let nivel = document.getElementById('tipo').value;

  if (nivel == '2') {
    document.getElementById('mod_btn_eliminar_lider').click();
    document.getElementById('mod_row_seleccionar_lider').hidden = true;
  }else{
    document.getElementById('mod_row_seleccionar_lider').hidden = false;
    document.getElementById('mod_btn_eliminar_lider').click();
  }
}
document.getElementById('btn_eliminar_lider').onclick = function() {
  // document.getElementById('btn_eliminar_lider').hidden = true;
  document.getElementById('search_lider').disabled = false;
  document.getElementById('search_lider').style.color = '#000';
  document.getElementById('search_lider').value = '';
  document.getElementById('id_lider').value = "";
}
document.getElementById('mod_btn_eliminar_lider').onclick = function() {
  // document.getElementById('mod_btn_eliminar_lider').hidden = true;
  document.getElementById('mod_search_lider').disabled = false;
  document.getElementById('mod_search_lider').style.color = '#000';
  document.getElementById('mod_search_lider').value = '';
  document.getElementById('mod_id_lider').value = "";
}

document.getElementById('agregar_cliente_cedula').addEventListener('input', ()=>{ 
  let cod = document.getElementById('agregar_cliente_cedula').value
  document.getElementById('agregar_cliente_codigo_hidden').value = cod;
  document.getElementById('agregar_cliente_codigo').value = cod;
})
document.getElementById('mod_cliente_ci').addEventListener('input', ()=>{ 
  let cod = document.getElementById('mod_cliente_ci').value
  document.getElementById('mod_cliente_ca_hidden').value = cod;
  document.getElementById('mod_cliente_ca').value = cod;
})
  // $(document).ready(function() {
  //   $('select').material_select();
  // });
</script>

</div>
</div>
</body>
</html>