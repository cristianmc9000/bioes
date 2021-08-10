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

<!DOCTYPE html>
<html lang="en">

<head>
    <style>

    .fuente {
        font-family: 'Segoe UI light';
        color: red;
    }

    table.highlight>tbody>tr:hover {
        background-color: #a0aaf0 !important;
    }

    .borde_tabla {
        border: 1px solid;
        border-collapse: collapse !important;
    }


    .borde_tabla tr th, .borde_tabla tr td {
        border: 1px solid;
        border-collapse: collapse !important;
        padding-top: 0px;
        padding-bottom: 0px;
    }
    .helpertext {
        top: -20px;
        position: relative;
        color: red;
    }
    </style>
</head>

<body>
    <div class="col s11">
        <div class="col s1">
                <b style= "color:blue"> Gestión:</b>
                <select onchange="enviarges()" name="ges" id="ges" class="browser-default">
                    <option value="0" selected disabled> Seleccionar</option>
                    <option value="2021"> 2021 </option>
                    <option value="2022"> 2022 </option>
                    <option value="2023"> 2023 </option>
                    <option value="2024"> 2024 </option>
                    <option value="2025"> 2025 </option>
                </select>
        </div>
        <div class="col s10 m8 offset-m3">
            <span class="fuente"><h3>Registro de compras de la gestión: <?php echo $_GET['ges']?></h3></span> 
        </div>
    </div>
    
    <!-- TABLA -->
    <table id="tabla1" class="highlight">
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
                    <a href="#" onclick="modal_descuento('<?php echo $valor["codc"] ?>','<?php echo $valor['descuento']?>')" style="background-color: #bdc3c7;" class="btn-flat waves-light waves-effect"><?php echo $valor["descuento"] ?> %</a>
                </td>
                <td>
                    <a href="#" onclick="modal_cambio('<?php echo $valor["codc"] ?>','<?php echo $valor['valor_pesos']?>')" style="background-color: #bdc3c7;" class="btn-flat waves-light waves-effect"><?php echo $valor["valor_pesos"] ?> Bs.</a>
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
    <!-- Modal registro de venta detalle de venta -->
    <div class="row">
        <div id="modal1" class="modal">
            <div class="modal-content">
                <div class="row">
                    <div class="col s12">
                        <center><b><h5>Detalle de compra</h5></b></center>
                    </div>
                    <div class="col s12">
                        <div class="col s12">
                        <h5>TOTALES:</h5>
                        </div>
                        <div class="col s4">
                            <span id="fecha_com"></span><br>
                            <span id="items"></span><br>
                            <span id="gan_exp"></span><br>
                            <span id="total"></span>
                        </div>
                    </div>
                    <div class="col s12">
                        <p>
                            <h5>Items del comprobante</h5>
                        </p>
                    </div>
                    <div class="col s12">
                        <table id="detalle_ven" class="borde_tabla">
                            <tr>
                                <th>Código <br> (producto)</th>
                                <th>Linea</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>P. unidad</th>
                                <th>Subtotal</th>
                            </tr>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

<!-- MODAL ADMINISTRAR PAGOS -->
    <div class="row">
        <div id="modal2" class="modal">
            <div class="modal-content">
                <input id="codc" type="text" value="" hidden >
                <div class="row">
                    <p>
                        <h4  class="fuente">Modificar detalle de compra</h4>
                    </p><br>

                    <table id="tabla_compras" class="borde_tabla">
                        <tr>
                            <th>Código</th>
                            <th>Línea</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>P. Unidad</th>
                            <th>Subtotal</th>
                            <th>Borrar</th>
                        </tr>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="btn red modal-action modal-close waves-effect waves-light left">Cancelar</a>
                <a href="#!" id="btn-cerrar_modal2" class="modal-action modal-close waves-effect waves-light btn green">Aceptar</a>
            </div>
        </div>
    </div>



<!-- MODAL MODIFICAR VALOR DE CAMBIO  -->
    <div class="row">
        <div id="modal3" class="modal col s4 offset-s4">
            <div class="modal-content">
                <input id="codc" type="text" value="codc" hidden>
                <div class="row">
                    <center><h4 class="fuente">Modificar valor del cambio.</h4></center><br>
                    <div class="col s3 offset-s2"><input type="text" style="color: black" value="1" disabled>
                        <small class="helpertext">Peso argentino</small>
                    </div>
                    <div style="padding: 15px" class="col s2">
                        <i class="material-icons">forward</i>
                    </div>
                    <div class="col s3"><input maxlength="5" onkeypress="return check(event)" id="v_cambio" type="text" value="">
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

<!-- MODAL MODIFICAR PORCENTAJE DE DESCUENTO -->
    <div class="row">
        <div id="modal4" class="modal col s4 offset-s4">
            <div class="modal-content">
                <input id="codc_desc" type="text" hidden>
                <div class="row">
                    <center><h4 class="fuente">Modificar porcentaje de descuento.</h4></center><br>

                    <div class="col l3 offset-l5 m8 offset-m2 s12">
                        <input maxlength="2" onkeypress="return check(event)" id="mod_desc" type="text" value="">
                        <small class="helpertext">% Descuento</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-light btn left red">Cancelar</a>
                <a href="#!" onclick="mod_descuento()" class="modal-action modal-close waves-effect waves-light btn">Confirmar</a>
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
    $('#modal').leanModal();
    $('.modal_trigger_3').leanModal();
    
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
        $("#fecha_com").html("<b>Fecha de compra: </b>"+fecha)
        $("#items").html("<b>Items: </b>"+cantidad+"u. Incluye "+auxiliares+" auxiliares.")
        $("#gan_exp").html("<b>Ganancias: </b>"+((gan_exp).toFixed(1))+" Bs.")
        $("#total").html("<b>Total:</b> "+total +" Bs.")
        $("#modal1").openModal()
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

    $("#modal2").openModal({dismissible: false})
}

//FUNCION PARA BORRAR UN ITEM DE LA BASE DE DATOS TABLA: DETALLE_COMPRA, COMPRA, INVENTARIO, INVCANT
function borrar_item(e, codp, codc, cant) {

    $.ajax({
            url: "recursos/compras/borrar_item.php?codc="+codc+"&codp="+codp+"&cant="+cant,
            method: "GET",
            success: function(response) {
                console.log(response)
                if(response == "0"){
                    Materialize.toast("La cantidad a eliminar supera al stock de inventario.", 4000)
                }else{  
                    e.target.parentNode.parentNode.parentNode.remove()
                    Materialize.toast("Item eliminado", 3000)
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
    $("#modal4").openModal()
}
function mod_descuento() {
    let descuento = $("#mod_desc").val()
    let codc = $("#codc_desc").val()
    let get_url = '?codc='+codc+'&descuento='+descuento

    if ($("#mod_desc").val() == "" || (parseFloat(descuento)<0)) {
        return Materialize.toast("Debe ingresar datos válidos", 3000)
    }
    $.ajax({
            url: "recursos/compras/mod_descuento.php"+get_url,
            method: "GET",
            success: function(response) {
                console.log(response)
                Materialize.toast("Descuento modificado.", 4000)
                let ges = "<?php echo $_GET['ges'] ?>"
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
    $("#modal3").openModal()
}
function mod_cambio() {

    let cambio = $("#v_cambio").val()
    let codc = $("#codc").val()
    let get_url = '?codc='+codc+'&cambio='+cambio 

    if ($("#v_cambio").val() == "" || (parseFloat(cambio)<0)) {
        return Materialize.toast("Debe ingresar datos válidos", 3000)
    }
    $.ajax({
            url: "recursos/compras/mod_cambio.php"+get_url,
            method: "GET",
            success: function(response) {
                console.log(response)
                Materialize.toast("Valor de cambio modificado.", 4000)
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
    $("#cuerpo").load("templates/ventas/reg_ventas.php?ges="+ges);
}
</script>

</body>
</html>