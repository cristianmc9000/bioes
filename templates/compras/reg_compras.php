<?php
require('../../recursos/sesiones.php');
session_start();
require('../../recursos/conexion.php');

// echo $_GET['ges'];

$Sql = "SELECT a.codc, a.fecha, a.totalsd, a.totalcd, a.descuento, a.valor_pesos FROM compras a WHERE a.estado = 1 AND a.fecha LIKE '".$_GET['ges']."%'"; 
$Busq = $conexion->query($Sql); 
if((mysqli_num_rows($Busq))>0){
    while($arr = $Busq->fetch_array()) 
        { 
            $fila[] = array('codc'=>$arr['codc'], 'fecha'=>$arr['fecha'],'totalsd'=>$arr['totalsd'],'totalcd'=>$arr['totalcd'],'descuento'=>$arr['descuento'], 'valor_pesos'=>$arr['valor_pesos']);
        } 
}else{
    $fila[] = array('codc'=>'--', 'fecha'=>'--','totalsd'=>'--','totalcd'=>'--','descuento'=>'--', 'valor_pesos'=>'--');
}
?>

<style>
.helpertext {
    top: -5px;
    position: relative;
    color: red;
    font-size: 0.7em;
}
</style>


<div class="d-block">
    <div class="row">
        <div class="col-sm-12 col-md-3">
            <!-- <label for="ges" class="form-label small text-muted">Gestión:</label> -->
            <div class="input-group mb-1">
                <div class="input-group-prepend"></div>
                <select onchange="enviarges()" id="ges" name="ges" class="form-select">
                    <option value="0" selected disabled> Seleccionar Gestión</option>
                    <option value="2021"> 2021 </option>
                    <option value="2022"> 2022 </option>
                    <option value="2023"> 2023 </option>
                    <option value="2024"> 2024 </option>
                    <option value="2025"> 2025 </option>
                </select>
            </div>
        </div>
    </div>
    <div class="d-block">
        <span class="fuente"><h3>Registro de compras de la gestión: <?php echo $_GET['ges']?></h3></span> 
    </div>
</div>
    
<!-- TABLA -->
<div class="row">
    <div class="col-md-11 col-sm-12">
        <table id="tabla1" class="table content-table table-hover ">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Fecha de compra</th>
                    <th>Total sin descuento</th>
                    <th>Total con descuento</th>
                    <th>Descuento</th>
                    <th>Valor de cambio</th>
                    <th>Detalle</th>
                    <th>Modificar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($fila as $a  => $valor){ ?>
                <tr>
                    <td>
                        <?php echo $valor["codc"] ?>
                    </td>
                    <td>
                        <?php echo $valor["fecha"] ?>
                    </td>
                    <td>
                        <?php echo $valor["totalsd"] ?> Bs.
                    </td>
                    <td>
                        <?php echo $valor["totalcd"] ?> Bs.
                    </td>
                    <td>
                        <button onclick="modal_descuento('<?php echo $valor["codc"] ?>','<?php echo $valor['descuento']?>')" class="btn btn-outline-primary btn-sm"><?php echo $valor["descuento"] ?> %</button>
                    </td>
                    <td>
                        <button onclick="modal_cambio('<?php echo $valor["codc"] ?>','<?php echo $valor['valor_pesos']?>')" class="btn btn-outline-primary btn-sm"><?php echo $valor["valor_pesos"] ?> Bs.</button>
                    </td>
                    <td>
                        <a href="#!" onclick="ver_compra('<?php echo $valor['codc']?>', '<?php echo $valor['fecha'] ?>', '<?php echo $valor['totalcd'] ?>' )"><i class="material-icons">visibility</i></a>
                    </td>
                    <td>
                        <a href="#" onclick="mod_compra(event, '<?php echo $valor['codc'] ?>','<?php echo $valor['descuento']?>','<?php echo $valor['valor_pesos']?>')"><i class="material-icons">build</i></a>
                    </td>
                </tr>
                <?php } ?>
                
            </tbody>
        </table>
    </div>
</div>

<!-- Modal registro de venta detalle de venta -->
<div id="modal1" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Detalle de compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-block">
                    <h5>TOTALES:</h5>
                    <span id="fecha_com"></span><br>
                    <span id="items"></span><br>
                    <span id="gan_exp"></span><br>
                    <span id="total"></span>
                </div>
                <div class="d-block">
                    <p><h5>Items del comprobante</h5></p>
                </div>
                <div class="d-block">
                    <table id="detalle_ven" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Código <br> (producto)</th>
                                <th>Linea</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>P. unidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Cerrar</button>
                <!-- <button form="agregar_producto" type="submit" class="btn btn-primary" id="btn-add_prod" >Aceptar</button> -->
            </div>
        </div>
    </div>
</div>


<!-- MODAL MODIFICAR COMPRA -->
<div id="modal2" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="label_reg_compras" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_reg_compras">Modificar detalle de compra</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <input id="codc" type="text" value="" hidden >
                <table id="tabla_compras" class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Línea</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>P. Unidad</th>
                            <th>Subtotal</th>
                            <th>Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button> -->
                <button id="btn-cerrar_modal2" data-bs-dismiss="modal" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </div>
</div>




<!-- MODAL MODIFICAR VALOR DE CAMBIO  -->
<div id="modal3" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificar valor de cambio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6 offset-md-3">
                        <input id="codc" type="text" value="codc" hidden>

                        <input type="text" class="form-control" value="1" disabled>
                        <small class="helpertext">Peso argentino</small>
                        
                        <!-- <div style="padding: 15px" class="col s2"> -->
                        <div class="d-flex justify-content-center">
                            <i class="material-icons">arrow_downward</i>
                        </div>
                        <!-- </div> -->
                        <input maxlength="5" class="form-control" onkeypress="return check(event)" id="v_cambio" type="text" value="">
                        <small class="helpertext">Bolivianos</small>
                    </div>
                </div>
            </div>
        
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-light btn left red">Cancelar</a>
                <a href="#!" onclick="mod_cambio()" class="modal-action modal-close waves-effect waves-light btn">Confirmar</a>
            </div>
        </div>
    </div>
</div>


<!-- MODAL MODIFICAR PORCENTAJE DE DESCUENTO -->
<div id="modal4" class="modal fade" tabindex="-1" aria-labelledby="descuento_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="descuento_label" class="modal-title" >Modificar porcentaje de descuento.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input id="codc_desc" type="text" hidden>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label class="form-label small text-muted" for="desc_porcentaje">Porcentaje de descuento:</label>
                        <input name="desc_porcentaje" class="form-control" maxlength="2" onkeypress="return check(event)" id="mod_desc" type="text" value="">
                        <small class="helpertext">% Descuento</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button onclick="mod_descuento()" class="btn btn-primary" >Confirmar</button>
            </div>
        </div>
    </div>
</div>


    <div id="mensaje"></div>

<!-- -----------------CRUD DE USUARIOS------------------------ -->
<script>
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
      }
      }
    });
    
});
var mensaje = $("#mensaje");
mensaje.hide();

/* funcion ver venta */
function ver_compra(codc, fecha, total) {
    detalle_compra(codc).then(respuesta => {
        let cantidad = 0
        let auxiliares = 0
        let gan_exp = 0

        var jsonParsedArray = JSON.parse(respuesta)

        //INSERTANDO FILAS A LA TABLA DETALLE DE VENTA 
        let table = document.getElementById("detalle_ven")
        $(".dinamic_rows").remove();
        for (key in jsonParsedArray) {
            if (jsonParsedArray.hasOwnProperty(key)) {
                let newTableRow = table.insertRow(-1)
                newTableRow.className = "dinamic_rows"
                newRow = newTableRow.insertCell(0)
                newRow.textContent = jsonParsedArray[key]['codp']

                newRow = newTableRow.insertCell(1)
                newRow.textContent = jsonParsedArray[key]['linea']

                newRow = newTableRow.insertCell(2)
                newRow.textContent = jsonParsedArray[key]['descripcion']

                newRow = newTableRow.insertCell(3)
                newRow.textContent = jsonParsedArray[key]['cantidad']

                newRow = newTableRow.insertCell(4)
                newRow.textContent = jsonParsedArray[key]['pubs_cd'] +" Bs."

                newRow = newTableRow.insertCell(5)
                newRow.textContent = ((parseInt(jsonParsedArray[key]['cantidad']) * parseFloat(jsonParsedArray[key]['pubs_cd'])).toFixed(1)) +" Bs."

                if (jsonParsedArray[key]['codli'] == 16 || (jsonParsedArray[key]['codli'] >= 32 && jsonParsedArray[key]['codli'] <= 37)) {
                    auxiliares += parseInt(jsonParsedArray[key]['cantidad']) 
                }
                cantidad += parseInt(jsonParsedArray[key]['cantidad']) 
                
                gan_exp = gan_exp + (parseFloat(jsonParsedArray[key]['pubs']) * parseInt(jsonParsedArray[key]['cantidad']) - parseFloat(jsonParsedArray[key]['pubs_cd']) * parseInt(jsonParsedArray[key]['cantidad']))

            }
        }
        $("#fecha_com").html("<b style='font-weight: bold'>Fecha de compra: </b>"+fecha)
        $("#items").html("<b style='font-weight: bold'>Items: </b>"+cantidad+"u. Incluye "+auxiliares+" auxiliares.")
        $("#gan_exp").html("<b style='font-weight: bold'>Ganancias: </b>"+((gan_exp).toFixed(1))+" Bs.")
        $("#total").html("<b style='font-weight: bold'>Total:</b> "+total +" Bs.")
        $("#modal1").modal('toggle')
    })
}
//OBTENER EL DETALLE DE COMPRA EN JSON
function detalle_compra(codc) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "recursos/compras/ver_compra.php?codc="+codc,
            method: "GET",
            success: function(response) {
                resolve(response)
            },
            error: function(error) {
                console.log(error)
                reject(error)
            }
        })
    })
}

//FUNCION PARA MODIFICAR LA COMPRA
function mod_compra(e, codc, descuento, valor) {
    $("#codc").val(codc)
    $("#descuento_mod").val(descuento)
    $("#valor_cambio").val(valor)
    $("#descuento_ant").val(descuento)
    $("#cambio_ant").val(valor)

    detalle_compra(codc).then(respuesta => {
        $(".dinamic_rows").remove();
        var jsonParsedArray = JSON.parse(respuesta)

        //INSERTANDO FILAS A LA TABLA VER PAGOS
        let table = document.getElementById("tabla_compras")
        for (key in jsonParsedArray) {
            if (jsonParsedArray.hasOwnProperty(key)) {
                let newTableRow = table.insertRow(-1)
                newTableRow.className = "dinamic_rows"
                newRow = newTableRow.insertCell(0)
                newRow.textContent = jsonParsedArray[key]['codp']

                newRow = newTableRow.insertCell(1)
                newRow.textContent = jsonParsedArray[key]['linea']

                newRow = newTableRow.insertCell(2)
                newRow.textContent = jsonParsedArray[key]['descripcion']

                newRow = newTableRow.insertCell(3)
                newRow.textContent = jsonParsedArray[key]['cantidad']

                newRow = newTableRow.insertCell(4)
                newRow.textContent = jsonParsedArray[key]['pubs_cd'] +" Bs."

                newRow = newTableRow.insertCell(5)
                newRow.textContent = ((parseInt(jsonParsedArray[key]['cantidad']) * parseFloat(jsonParsedArray[key]['pubs_cd'])).toFixed(1)) +" Bs."

                newRow = newTableRow.insertCell(6)
                let codp_b = jsonParsedArray[key]['codp']
                let cant = jsonParsedArray[key]['cantidad']
                newRow.innerHTML = "<a href='#' onclick='borrar_item(event,`"+codp_b+"`,"+codc+", "+cant+")' style='color:red'><i class='material-icons'>delete</i></a>"
            }
        }
    })

    $("#modal2").modal('toggle')
}

//FUNCION PARA BORRAR UN ITEM DE LA BASE DE DATOS TABLA: DETALLE_COMPRA, COMPRA, INVENTARIO, INVCANT
function borrar_item(e, codp, codc, cant) {

    $.ajax({
            url: "recursos/compras/borrar_item.php?codc="+codc+"&codp="+codp+"&cant="+cant,
            method: "GET",
            success: function(response) {
                console.log(response)
                if(response == "0"){
                    mtoast("La cantidad a eliminar supera al stock de inventario.", "danger")
                }else{  
                    e.target.parentNode.parentNode.parentNode.remove()
                    mtoast("Item eliminado", "success")
                    let ges = "<?php echo $_GET['ges'] ?>"
                    $("#btn-cerrar_modal2").attr('onclick', '$("#cuerpo").load("templates/compras/reg_compras.php?ges='+ges+'")');
                }

            },
            error: function(error) {
                console.log(error)
            }
    })
    
}

//funciones para modificar el porcentaje de descuento
function modal_descuento(codc, descuento) {
    $("#codc_desc").val(codc)
    $("#mod_desc").val(descuento)
    $("#modal4").modal('toggle')
}
function mod_descuento() {
    let descuento = $("#mod_desc").val()
    let codc = $("#codc_desc").val()
    let get_url = '?codc='+codc+'&descuento='+descuento

    if ($("#mod_desc").val() == "" || (parseFloat(descuento)<0)) {
        return mtoast("Debe ingresar datos válidos", "danger")
    }
    $.ajax({
            url: "recursos/compras/mod_descuento.php"+get_url,
            method: "GET",
            success: function(response) {
                console.log(response)
                mtoast("Descuento modificado.", "success")
                let ges = "<?php echo $_GET['ges'] ?>"
                $("#modal4").modal('toggle')
                $("#cuerpo").load("templates/compras/reg_compras.php?ges="+ges)
            },
            error: function(error) {
                console.log(error)
            }
    })
}
//funciones para modificar el valor de cambio pesos a bs.
function modal_cambio(codc, cambio) {
    $("#codc").val(codc)
    $("#v_cambio").val(cambio)
    $("#modal3").modal('toggle')
}
function mod_cambio() {

    let cambio = $("#v_cambio").val()
    let codc = $("#codc").val()
    let get_url = '?codc='+codc+'&cambio='+cambio 

    if ($("#v_cambio").val() == "" || (parseFloat(cambio)<0)) {
        return mtoast("Debe ingresar datos válidos", "warning")
    }
    $.ajax({
            url: "recursos/compras/mod_cambio.php"+get_url,
            method: "GET",
            success: function(response) {
                console.log(response)
                mtoast("Valor de cambio modificado.", "success")
                let ges = "<?php echo $_GET['ges'] ?>"
                $("#cuerpo").load("templates/compras/reg_compras.php?ges="+ges)
            },
            error: function(error) {
                console.log(error)
            }
    })
}


//funcion gestión
function enviarges() {
    ges = $('#ges').val();
    console.log(ges)
    $("#cuerpo").load("templates/compras/reg_compras.php?ges="+ges);
}
</script>
