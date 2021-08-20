<?php
require('../../recursos/conexion.php');
$_SESSION['filas'] = array(); 
$Sql = "SELECT * FROM usuarios"; 
$Busq = $conexion->query($Sql); 
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('ci'=>$arr['CI'], 'nombre'=>$arr['nombre'], 'apellidos'=>$arr['apellidos'], 'telefono'=>$arr['telefono'],'password'=>$arr['password'],'rol'=>$arr['rol']);
        array_push($_SESSION['filas'],$fila); 
    } 
?>


<div class="container-fluid">
<span class="fuente"><h3>Usuarios
  <!-- Modal Trigger -->
  <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modal1"><i  class="material-icons-outlined align-middle">add</i>Agregar</button>

  <!-- <a class="waves-effect waves-light btn-floating btn-large red" id="modal" href="#modal1"><i class="material-icons left">add</i></a>  --></h3>
</span><br>
  <!-- TABLA -->
  <div class="row">
    <div class="col-md-11">
      <table id="tabla1" class="table table-dark table-bordered table-hover">
        <thead class="">
          <tr>
              <th scope="col">CI</th> 
              <th scope="col">Nombres y apellidos</th>
              <th scope="col">Telefono</th>
              <th scope="col">Rol</th>
              <th scope="col">Modificar</th>
              <!-- <th>Borrar</th> -->
          </tr>
        </thead>
        <tbody>
        <?php foreach($fila as $a  => $valor){ ?>
          <tr>
            <td><?php echo $valor["ci"] ?></td>
            <td><?php echo $valor["nombre"]." ".$valor["apellidos"] ?></td>
            <td><?php echo $valor["telefono"] ?></td>
            <td><?php if($valor['rol'] == '1') {echo 'Administrador';}else{echo 'Vendedor';}?></td>
            <td><a href="#!" onclick="modificar_usuario('<?php echo $valor['ci']?>','<?php echo $valor['nombre']?>','<?php echo $valor['apellidos']?>','<?php echo $valor['telefono']?>','<?php echo $valor['rol']?>')"><i class="material-icons-outlined">build</i></a></td>
            <!-- <td><a href="#"><i class="material-icons">delete</i></a></td>         -->
          </tr>
        <?php } ?>	
        </tbody>
      </table>
    </div>
  </div>

<!-- MODAL NUEVO USUARIO DATOS -->

<div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_modal1">Agregar usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form id="agregar_usuario" >
            <div class="row g-3">
              <div class="col-sm-12 col-md-6">
                <label for="ci" class="form-label small text-muted">Cédula de Identidad</label>
                <input type="text" name="ci" class="form-control">
              </div>
              <div class="col-sm-12 col-md-6">
                <label for="telefono" class="form-label small text-muted">Telf./Celular</label>
                <input type="text" id="telefono" name="telefono" class="form-control">
              </div>

              <div class="col-sm-12 col-md-6">
                <label for="nombre" class="form-label small text-muted">Nombre:</label>
                <input name="nombre" type="text" class="form-control">
              </div>
              <div class="col-sm-12 col-md-6">
                <label for="apellidos" class="form-label small text-muted">Apellidos:</label>
                <input name="apellidos" type="text" class="form-control" autocomplete="off">
              </div>         

              <div class="col-sm-12 col-md-6">
                <label for="password" class="form-label small text-muted">Contraseña:</label>
                <input name="password" type="password" class="form-control" autocomplete="new-password">
              </div>
              <div class="col-sm-12 col-md-6">
                <label for="password1" class="form-label small text-muted">Repita la contraseña:</label>
                <input name="password1" class="form-control" type="password">
              </div>

              <div class="col-sm-12">
                <div class="input-group mb-1">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Rol</label>
                  </div>
                  <select name="rol" class="form-select" id="inputGroupSelect01">
                    <option value="1">Administrador</option>
                    <option value="2">Vendedor</option>
                  </select>
                </div>
              </div>
            </div> 
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button form="agregar_usuario" type="submit" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>



<!-- -----------modal modificar usuario------------ -->
<div class="row">
  <div id="modal2" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="titulo_modal1">Modificar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

              <form id="modificar_usuario">
                <div class="row g-3">
                  <div class="col-sm-12 col-md-6">
                    <label class="form-label small text-muted" for="ci">Cédula de Identidad:</label>
                    <input id="m_ci" name="ci" type="text" class="form-control">
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <label class="form-label small text-muted" for="telefono">Teléfono:</label>
                    <input id="m_telefono" name="telefono" type="number" class="form-control">
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <label class="form-label small text-muted" for="nombre">Nombre:</label>
                    <input id="m_nombre" name="nombre" type="text" class="form-control">
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <label class="form-label small text-muted" for="apellidos">Apellidos:</label>
                    <input id="m_apellidos" name="apellidos" type="text" value="" autocomplete="off" class="form-control">
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <label class="form-label small text-muted" for="password">Nueva Contraseña:</label>
                    <input id="m_password" name="password" type="password" value="" autocomplete="new-password" class="form-control">
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <label class="form-label small text-muted" for="password1">Repita la contraseña:</label>
                    <input id="m_password1" name="password1" type="password" class="form-control">
                  </div>
                  <div class="col-sm-12">
                    <div class="input-group mb-1">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Rol</label>
                      </div>
                      <select id="rol" name="rol" class="form-select" id="inputGroupSelect01">

                      </select>
                    </div>
                  </div>
                </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button form="modificar_usuario" type="submit" class="btn btn-primary">Aceptar</button>
      </div>
      </div>
    </div>
  </div>
</div>
</div> <!-- CONTAINER FUILD END -->
<div id="mensaje"></div>

<!-- <div id="EpicToast" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div id="btoast" class="toast-body">
      Hello, world! This is a toast message.
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>  --> 

<!-- -----------------CRUD DE USUARIOS------------------------ -->
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
    // $('#modal').leanModal();
});
var mensaje = $("#mensaje");
mensaje.hide();
/* agregar usuario */
$("#agregar_usuario").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("agregar_usuario"));
    $.ajax({
      url: "recursos/usuarios/agregar_usuario.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      mensaje.html(echo);
      if (echo.includes('success')) {
        $("#cuerpo").load("templates/usuarios/a_usuarios.php");
      }
    });
});


function modificar_usuario(ci, nombre, apellidos, telefono, rol){
  $("#m_ci").val(ci)
  $("#m_telefono").val(telefono)
  $("#m_nombre").val(nombre)
  $("#m_apellidos").val(apellidos)
  let selad = ""
  let selve = ""
  if (rol == 1) {selad = 'selected'}
  else{selve = 'selected'}
  document.getElementById('rol').innerHTML = `<option value="1" ${selad}>Administrador</option><option value="2" ${selve}>Vendedor</option>`;

  $("#modal2").modal("show")
}
/* agregar usuario */
$("#modificar_usuario").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("modificar_usuario"));
    $.ajax({
      url: "recursos/usuarios/modificar_usuario.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
        console.log(echo)
        mensaje.html(echo)
        if (echo == 1) {
          Materialize.toast("<b>Usuario modificado.</b>",5000)
          $("#modal2").closeModal()
          $("#cuerpo").load("templates/usuarios/a_usuarios.php")
        }
    });
});
</script>
</div>