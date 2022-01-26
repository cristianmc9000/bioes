    <?php
require('../../recursos/conexion.php');
require('../../recursos/sesiones.php');

/* $anio = $_GET["anio"]; */

// session_start();
/* $_SESSION['anio'] = $anio; */

// $Sql = "SELECT a.id, a.foto, b.nombre, b.codli, a.descripcion, a.pupesos, a.pubs, a.cantidad, a.fechav FROM productos a, lineas b WHERE a.estado = 1 and a.linea = b.codli and fechareg LIKE '".$anio."-%-%' and periodo = ".$per; 

$Sql = "SELECT a.id, a.foto, b.nombre, b.codli, a.descripcion, c.cantidad, a.combo FROM productos a, lineas b, invcant c WHERE a.id = c.codp AND a.estado = 1 AND a.linea = b.codli"; 

$Busq = $conexion->query($Sql); 

if((mysqli_num_rows($Busq))>0){
  while($arr = $Busq->fetch_array()){ 

        $fila[] = array('id'=>$arr['id'], 'foto'=>$arr['foto'], 'linea'=>$arr['nombre'], 'codli'=>$arr['codli'], 'descripcion'=>$arr['descripcion'], 'cantidad'=>$arr['cantidad'], 'combo'=>$arr['combo']); 

  }
}else{
        $fila[] = array('id'=>'--','foto'=>'--','linea'=>'--','codli'=>'--','descripcion'=>'--','pupesos'=>'--','pubs'=>'--','cantidad'=>'--','combo'=>'--');
}
  //consulta de lineas
$Sql2 = "SELECT codli, nombre FROM lineas WHERE estado = 1";
$Busq2 = $conexion->query($Sql2);
if((mysqli_num_rows($Busq2))>0){
  while($arr2 = $Busq2->fetch_array()){ 

        $fila2[] = array('codli'=>$arr2['codli'], 'nombre'=>$arr2['nombre']); 

  }
}
?>

<style>
    /* table.dataTable tbody th, table.dataTable tbody td {
      padding: 0;
    } */
    .izq{
    /*float: left;*/
    position: absolute;
    left: 10px;
    }
    .ui-autocomplete{
        z-index: 1099;
    }
    .ui-autocomplete-row
    {
      /*padding:8px;*/
      background-color: #f4f4f4;
      border-bottom:1px solid #ccc;
      font-weight:bold;
    }
    .ui-autocomplete-row:hover
    {
      background-color: #ddd;
      /*font-family: "Segoe UI Light"*/
    }
    .zoom {
        transition: transform .2s; 
    }

    .zoom:hover {
        transform: scale(1.3); 
    }

</style>
<div class="row">
    <div class="col-md-4">
      <span class="fuente"><h3>Productos
      <!-- Modal Trigger -->
      <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modal1"><i  class="material-icons-outlined align-middle">add</i>Agregar</button></h3>
      </span>
    </div>
    <div class="col-md-2 offset-md-1">
        <button type="button" class="btn btn-danger btn-lg" onclick="cargar_lineas()"><i class="material-icons-outlined align-middle">grading</i>Ver líneas</button>
    </div>
</div>
        <!-- TABLA -->
        <div class="row">
        <div class="col-md-11">
            <table id="tabla1" class="table content-table table-hover">
                <thead>
                    <tr>
                        <th>Ver</th>
                        <th>Código<br>(Producto)</th>
                        <th>Linea</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Modificar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($fila as $a  => $valor){ ?>
                    <tr>
                        <td>
                          <img src="<?php echo $valor['foto']?>" width="50px" height="40px" alt="">
                        </td>
                        <td>
                            <?php echo $valor["id"] ?>
                        </td>
                        <td>
                            <?php echo $valor["linea"]?>
                        </td>
                        <td>
                            <?php echo $valor["descripcion"]?>
                        </td>
                        <td>
                            <?php echo $valor["cantidad"] ?>
                        </td>
                        <td>
                            <a href="#!" onclick="mod_producto('<?php echo $valor['foto']?>',`<?php echo $valor['id']?>`,`<?php echo $valor['linea'] ?>`,'<?php echo $valor['codli'] ?>',`<?php echo $valor['descripcion'] ?>`, '<?php echo $valor['combo'] ?>')"><i class="material-icons">build</i></a>
                        </td>
                        <td>
                            <a href="#!" onclick="borrar_producto('<?php echo $valor['id'] ?>');"><i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
          </div>
        </div>
        
<!--MODAL AGREGAR LINEA-->
<div id="modal_lin" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Líneas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="agregar_linea">
                    <div class="row g-3">
                        <div class="col-sm-12 col-md-6">
                            
                            <input placeholder="Nueva línea" name="linea_" id="linea_" type="text" class="form-control" required>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <button class="btn btn-primary" type="submit"><i class="material-icons align-middle">add</i>Agregar linea</button>
                        </div>
                    </div>
                </form>
                <br>
                <table id="tabla_lineas" class="table table-hover table-dark table-sm">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Modificar</th>
                            <th>Borrar</th>
                        </tr>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!--MODAL AGREGAR PRODUCTO-->
<div id="modal1" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="agregar_producto">
                    <div class="row g-3">
                        <div class="col-sm-12 input-group">
                            <input name="imagen" type="file" class="form-control" id="_imagen">
                            <label class="input-group-text" for="_imagen">Foto</label>

                            <input type="text" id="json_combo" name="json_combo" hidden>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label for="codigo" class="form-label small text-muted">Código:</label>
                            <input class="form-control" name="codigo" type="text" autocomplete="off" required>
                        </div>

                        <div class="col-sm-12 col-md-6">
                        <label for="linea" class="form-label small text-muted">Linea:</label>
                          <div class="input-group mb-1">
                          <div class="input-group-prepend">
                          
                          </div>
                          <select id="linea" name="linea" class="form-select">
                              <option value="" disabled selected>Linea</option>
                              <?php foreach($fila2 as $a  => $valor){ ?>
                              <option value="<?php echo $valor["codli"] ?>"><?php echo $valor["nombre"] ?></option>
                              <?php } ?>
                            </select>
                        </div>
                        </div>

                        <div class="col-sm-12">
                          <label class="form-label small text-muted" for="descripcion">Descripción:</label>
                          <textarea class="form-control" name="descripcion" autocomplete="off" required></textarea>     
                        </div>

                        <div id="combo_section" class="col-sm-12" hidden>
                            <span>Agregar productos al combo:</span>
                            <div class="input-group mb-3">
                              <span class="input-group-text" id="basic-addon1"><i class="material-icons">search</i></span>
                              <input type="text" id="search_data" class="form-control" placeholder="Buscar producto" aria-label="Buscar producto" aria-describedby="basic-addon1">
                            </div>

                            <table id="tabla_combo" class="content-table" width="100%">
                                <thead>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Borrar</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-check izq">
                  <input class="form-check-input" type="checkbox" value="" id="combo_check">
                  <label class="form-check-label text-muted" for="combo_check">
                    COMBO
                  </label>
                </div>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button form="agregar_producto" type="submit" class="btn btn-primary" id="btn-add_prod" >Aceptar</button>
            </div>
        </div>
    </div>
</div>
        <!--MODAL MODIFICAR PRODUCTO-->

<div id="modal2" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Modificar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modificar_producto">
                    <div class="row g-3">
                        <div class="col-sm-12 input-group">
                            <input id="imagen_ant" name="imagen_ant" type="text" hidden>
                            <input name="imagen" type="file" class="form-control" id="imagen">
                            <label class="input-group-text" for="imagen">Foto</label>

                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label class="form-label small text-muted" for="codigo">Código:</label>
                            <input id="codigo" class="form-control" name="codigo" type="text" required>
                            <input id="codigo_ant" name="codant" type="text" hidden>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <label for="linea" class="form-label small text-muted">Linea:</label>
                            <div class="input-group mb-1">
                                <div class="input-group-prepend"></div>
                                <select id="lin" name="linea" class="form-select">
                                    <option id="lin_prev" value="" ></option>
                                    <?php foreach($fila2 as $a  => $valor){ ?>
                                      <option value="<?php echo $valor["codli"] ?>"><?php echo $valor["nombre"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label class="form-label small text-muted" for="descripcion">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" autocomplete="off" required></textarea>
                        </div>

                        <div id="mod_combo_section" class="col-sm-12" hidden>
                            <span>Agregar productos al combo:</span>
                            <div class="input-group mb-3">
                              <span class="input-group-text" id="basic-addon1"><i class="material-icons">search</i></span>
                              <input type="text" id="mod_search_data" class="form-control" placeholder="Buscar producto" aria-label="Buscar producto" aria-describedby="basic-addon1">
                            </div>

                            <table id="mod_tabla_combo" class="content-table" width="100%">
                                <thead>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Borrar</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

                <div class="form-check izq">
                  <input class="form-check-input" type="checkbox" value="" id="mod_combo_check">
                  <label class="form-check-label text-muted" for="mod_combo_check">
                    COMBO
                  </label>
                </div>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button form="modificar_producto" type="submit" id="btn-mod_prod" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </div>
</div>
   

<!--MODAL BORRAR CLIENTE-->
<div id="modal3" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Borrar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <p>¿Esta seguro que desea eliminar este producto?</p>
                <form id="eliminar_producto">
                    <div class="row g-3">
                        <div class="input-field col-md-12">
                            <input id="datos_borrar" name="id" type="text" hidden>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" form="eliminar_producto" type="submit">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- PARA RECIBIR MENSAJES DESDE PHP -->  
    <div id="mensaje" class="modal-content" hidden></div>

<script>
var mensaje = $("#mensaje");
let controller = 0;
$(document).ready(function() {
    
    $('#tabla1').dataTable({
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
          }},
    });

    $('#search_data').autocomplete({
      source: "recursos/compras/buscar_prod.php",
      minLength: 1,
      select: function(event, ui)
      {

        $('#search_data').val("123")
        //insertando filas a la tabla

        // let table = document.getElementById("tabla_combo")
        // $("#tabla_combo tbody").html("")
        let table = $("#tabla_combo tbody")[0];
        let newTableRow = table.insertRow(-1)
        let newRow

        newRow = newTableRow.insertCell(0)
        newRow.textContent = ui.item.id
        newRow.className = "_id"

        newRow = newTableRow.insertCell(1)
        newRow.textContent = ui.item.value
        newRow.className = "_nombre"

        newRow = newTableRow.insertCell(2)
        newRow.innerHTML = '<a href="#!" onclick="delete_row(event)" class="btn-floating red"><i class="material-icons">delete</i></a>'
        // newRow.className = "_descripcion"



      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        // console.log(item)
        return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };

    $('#mod_search_data').autocomplete({
      source: "recursos/compras/buscar_prod.php",
      minLength: 1,
      select: function(event, ui)
      {
        let id_combo = $("#codigo_ant").val()
        $.ajax({
              url: "recursos/productos/add_combo_item.php?id_combo="+id_combo+"&id_prod="+ui.item.id,
              //method: "GET",
              success: function(response) {

                    if (response == 1) {
                         //insertando filas a la tabla
                        let table = $("#mod_tabla_combo tbody")[0];
                        let newTableRow = table.insertRow(-1)
                        newTableRow.className = "dinamic_rows"

                        newRow = newTableRow.insertCell(0)
                        newRow.textContent = ui.item.id
                        newRow.className = "_id"

                        newRow = newTableRow.insertCell(1)
                        newRow.textContent = ui.item.value
                        newRow.className = "_nombre"

                        newRow = newTableRow.insertCell(2)
                        newRow.innerHTML = '<a href="#!" onclick="mod_delete_row(event, `'+id_combo+'`, `'+ui.item.id+'`)" class="btn-floating red"><i class="material-icons">delete</i></a>'
                        // newRow.className = "_descripcion"


                    }else{
                        console.log(response)
                    }
              },
              error: function(error) {
                  console.log(error)
              }
        })
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        // console.log(item)
        return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };

});

$('#modal2').on('hide.bs.modal', function (e) {
    let rows = document.getElementById('mod_tabla_combo').getElementsByTagName('tr')

    if (controller == 1 && rows.length < 3) {
        e.preventDefault();
        e.stopImmediatePropagation();
        mtoast("El combo debe contener 2 productos como mínimo, caso contrario desmarcar la opción combo.", 'warning');
        return false;
    }
    if (controller == 2) {
        $("#cuerpo").load('templates/productos/productos.php')
    }

});

function delete_row(e) {
  console.log(e.target.parentNode.parentNode.parentNode.remove())
  let rows = document.getElementById('tabla_combo').getElementsByTagName('tr')
}

function mod_delete_row(e, id_combo, id_prod) {

  $.ajax({
      url: "recursos/productos/delete_combo_item.php?id_combo="+id_combo+"&id_prod="+id_prod,
      //method: "GET",
      success: function(response) {
            if (response == 1) {
                console.log(e.target.parentNode.parentNode.parentNode.remove())
                // let rows = document.getElementById('mod_tabla_combo').getElementsByTagName('tr')

                if ($('#mod_combo_check').is(":checked")){
                    let rows = document.getElementById('mod_tabla_combo').getElementsByTagName('tr')
                    if (rows.length <= 1) {
                        document.getElementById("mod_combo_check").checked = false;
                        document.getElementById('mod_combo_section').hidden = true
                        combo_status(id_combo, '0');
                    }
                }

            }else{
                console.log(response)
            }
      },
      error: function(error) {
          console.log(error)
      }
  })



}

function combo_status(id, status) {
    $.ajax({
      url: "recursos/productos/combo_status.php?id="+id+"&status="+status,
      method: "GET",
      success: function(response) {
        console.log(response+" :Combo status")
      }
    })
}

// document.getElementById("combo_check").addEventListener("click", function(event) {
//     alert("hola");
// })

$("#combo_check").on("click", function () {
    if (!$('#combo_check').is(":checked")){
        document.getElementById('combo_section').hidden = true
    }else{
        document.getElementById('combo_section').hidden = false
    }
})

$("#mod_combo_check").on("click", function () {
    
    let id = $("#codigo_ant").val();
    if (!$('#mod_combo_check').is(":checked")){
        controller = 2;
        combo_status(id, '0')
        document.getElementById('mod_combo_section').hidden = true
    }else{
        controller = 1;
        combo_status(id, '1')
        document.getElementById('mod_combo_section').hidden = false
    }
})

//FUNCION PARA CARGAR LINEAS DESDE LA BASE DE DATOS
function cargar_lineas() {
  let respuesta
  $.ajax({
      url: "recursos/productos/ver_lineas.php",
      //method: "GET",
      success: function(response) {
            $(".dinamic_rows").remove();
            let jsonParsedArray = JSON.parse(response)
            //INSERTANDO FILAS A LA TABLA VER PAGOS
            let table = document.getElementById("tabla_lineas")
            for (key in jsonParsedArray) {
                if (jsonParsedArray.hasOwnProperty(key)) {
                    let newTableRow = table.insertRow(-1)
                    newTableRow.className = "dinamic_rows"

                    newRow = newTableRow.insertCell(0)
                    newRow.textContent = jsonParsedArray[key]['codli']

                    newRow = newTableRow.insertCell(1)
                    newRow.textContent = jsonParsedArray[key]['nombre']

                    newRow = newTableRow.insertCell(2)
                    newRow.innerHTML = '<a onclick="mod_linea(event, '+jsonParsedArray[key]['codli']+')" style="cursor:pointer"><i class="material-icons">build</i></a>'

                    newRow = newTableRow.insertCell(3)
                    newRow.innerHTML = '<a onclick="borrar_linea(event, '+jsonParsedArray[key]['codli']+')" style="cursor:pointer"><i class="material-icons">delete</i></a>'
                }
            }
            $("#modal_lin").modal("toggle")
      },
      error: function(error) {
          console.log(error)
      }
  })
}

function mod_linea(e, id) {

  let text = $('#tabla_lineas').find('._linea').val()
  $('#tabla_lineas').find('._linea').remove()
  $("#tabla_lineas").find('td').each (function() {
    if ($(this).html() == "") {
      $(this).html(text)
    }
  }); 

  e.target.parentNode.parentNode.parentNode.children[1].innerHTML = '<input type="text" onkeyup="onKeyUp(event)" class="_linea" value="'+e.target.parentNode.parentNode.parentNode.children[1].innerHTML+'">'
}
//funcion para detectar la tecla enter
function onKeyUp(e) {
  let keycode = e.keyCode;
    if(keycode == '13'){
      let linea = $("._linea").val()
      let codli = e.target.parentNode.parentNode.children[0].innerHTML
      $.ajax({
      url: "recursos/productos/modificar_linea.php?nombre="+linea+"&codli="+codli,
      method: "GET",
      success: function(response) {
        if (response) {
          mtoast("Línea modificada.", "success");
          e.target.parentNode.innerHTML = $("._linea").val()
        }
      },
      error: function(error) {
          console.log(error)
      }
  })

    }
}

function borrar_linea(e, id) {  
  $.ajax({
      url: "recursos/productos/borrar_linea.php?id="+id,
      method: "GET",
      success: function(response) {
          if(response){
              console.log(response +" respuesta de borrar_linea.php")
              mtoast("Línea eliminada.", "success")
              console.log(e.target.parentNode.parentNode.parentNode.remove())
          }else{
              mtoast("No se puede eliminar línea, contiene productos activos.", "warning")
          }
      },
      error: function(error) {
          console.log(error)
      }
  })
  
}

$("#agregar_producto").on("submit", function(e){
    e.preventDefault(); 

    if ( $("#linea").val() == null ) return mtoast("Debe seleccionar una línea.", "warning")

    if ($('#combo_check').is(":checked")){
        let rows = document.getElementById('tabla_combo').getElementsByTagName('tr')
        if (rows.length <= 2) {
            console.log(rows.length)
            return mtoast("El combo debe contener 2 productos como mínimo, caso contrario desmarcar la opción combo.", 'warning')
        }

        let combo_array = [];
        document.querySelectorAll('#tabla_combo tbody tr').forEach(function(e){
          let fila = {
            id: e.querySelector('._id').innerText
          };
          combo_array.push(fila)
        });
        $("#json_combo").val(JSON.stringify(combo_array))
    }else{
        $("#json_combo").val("")
    }

    
    $("#btn-add_prod").addClass('disabled')
    document.getElementById('btn-add_prod').disabled = true


    var val = new FormData(document.getElementById("agregar_producto"));
    $.ajax({
      url: "recursos/productos/agregar_producto.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
        console.log(echo)
      if (echo == "1") {
        $("#btn-add_prod").removeClass('disabled')
        document.getElementById('btn-add_prod').disabled = false
        mensaje.html(echo);
        console.log(echo)
        if (echo.includes("1")) {
          $("#modal1").modal('toggle'); 
          mtoast("PRODUCTO AGREGADO.", "success");
          $("#cuerpo").load("templates/productos/productos.php");
        } 

      }
    });
});

function mod_producto(foto, id, linea, codli, descripcion, combo) {
    // console.log(foto, id, linea, codli, descripcion, combo)
  $("#imagen_ant").val(foto)
  $("#codigo").val(id)
  $("#codigo_ant").val(id)
  //PARA SELECCIONAR LINEA 
  $("#lin_prev").val(codli)
  $("#lin_prev").html(linea)
  $("#lin_prev").prop("selected", true)
  // FIN SELECCIONAR LINEA
  $("#descripcion").val(descripcion)
  // $("#mod_combo_section")
  document.getElementById('mod_combo_section').hidden = true
  if (combo == '1') {
    document.getElementById('mod_combo_section').hidden = false
    document.getElementById("mod_combo_check").checked = true;
    $.ajax({
        url: "recursos/productos/combo_content.php?id="+id,
        method: "GET",
        success: function(response) {
            console.log(response)
            $(".dinamic_rows").remove();
            let table = $("#mod_tabla_combo tbody")[0];
            JSON.parse(response).forEach(function(element) {
                // console.log(element['id_prod'])
                let newTableRow = table.insertRow(-1)
                newTableRow.className = "dinamic_rows"
                // let newRow
                newRow = newTableRow.insertCell(0)
                newRow.textContent = element['id_prod']
                newRow.className = "_id"

                newRow = newTableRow.insertCell(1)
                newRow.textContent = element['nompro']
                newRow.className = "_nombre"

                newRow = newTableRow.insertCell(2)
                newRow.innerHTML = '<a href="#!" onclick="mod_delete_row(event, `'+id+'`, `'+element['id_prod']+'`)" class="btn-floating red"><i class="material-icons">delete</i></a>'

            });
        },
        error: function(error) {
            console.log(error)
        }
    })
  }else{
    document.getElementById("mod_combo_check").checked = false;
  }
  $("#modal2").modal('toggle')
}
    
$("#modificar_producto").on("submit", function(e){
    e.preventDefault();


    if ($('#mod_combo_check').is(":checked")){
        let rows = document.getElementById('mod_tabla_combo').getElementsByTagName('tr')
        if (rows.length <= 2) {
            console.log(rows.length)
            return mtoast("Debe seleccionar más de un producto o desmarcar la opción combo.", 'warning')
        }
    }


    $("#btn-mod_prod").addClass('disabled')
    document.getElementById('btn-mod_prod').disabled = true
    var val = new FormData(document.getElementById("modificar_producto"));
    $.ajax({
      url: "recursos/productos/modificar_producto.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        $("#btn-mod_prod").removeClass('disabled')
        document.getElementById('btn-mod_prod').disabled = false
        mensaje.html(echo);
        console.log(echo);
        if (echo.includes("1")) {
          $("#modal2").modal('toggle'); 
          mtoast("PRODUCTO MODIFICADO." , 'success');
          $("#cuerpo").load("templates/productos/productos.php");
        }
        
      }
    });
});

function borrar_producto(id){
  $("#datos_borrar").val(id)
  $('#modal3').modal('toggle')
}

$("#eliminar_producto").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("eliminar_producto"));
    $.ajax({
      url: "recursos/productos/borrarproducto.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
        mensaje.html(echo);
        console.log(echo);
        if (echo == "1") {
              $("#modal3").modal('toggle'); 
              mtoast("PRODUCTO ELIMINADO." , 'success');
              $("#cuerpo").load("templates/productos/productos.php");
        }
    });
});

$("#agregar_linea").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("agregar_linea"));
    $.ajax({
      url: "recursos/productos/agregar_linea.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
        mensaje.html(echo);
        console.log(echo);
        if (echo.includes('true')) {
          $("#modal_lin").modal('toggle'); 
          mtoast("LINEA AGREGADA.", "success");
          $("#cuerpo").load("templates/productos/productos.php");
        }
      })
    });

function convertira() {
  pesos = $("#pupesos").val()
  bs = pesos * parseFloat($("#valor").val());
  $("#pubs").val(bs.toFixed(2));
}
$("#pupesos").on("keydown input", function(){
  pesos = $("#pupesos").val()
  bs = pesos * parseFloat($("#valor").val());
  $("#pubs").val(bs.toFixed(2));
})

function convertirm() {
  pesos = $("#pup").val()
  bs = pesos * parseFloat($("#valor").val());
  $("#pub").val(bs.toFixed(2));
}
$("#pup").on("keydown input", function(){
  pesos = $("#pup").val()
  bs = pesos * parseFloat($("#valor").val());
  $("#pub").val(bs.toFixed(2));
})


</script>

