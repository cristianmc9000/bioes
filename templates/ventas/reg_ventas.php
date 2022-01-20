<?php
require('../../recursos/sesiones.php');
session_start();
require('../../recursos/conexion.php');

// echo $_GET['ges'];

$Sql = "SELECT a.codv, a.ca, b.nombre, b.apellidos, a.fecha, a.total, a.credito FROM ventas a, clientes b WHERE a.ca = b.CA AND a.estado = 1 AND a.fecha LIKE '".$_GET['ges']."%'"; 
$Busq = $conexion->query($Sql); 
if((mysqli_num_rows($Busq))>0){
    while($arr = $Busq->fetch_array()) 
        { 
            $fila[] = array('codv'=>$arr['codv'], 'ca'=>$arr['ca'],'nombre'=>$arr['nombre'],'apellidos'=>$arr['apellidos'],'lugar'=>$arr['lugar'],'fecha'=>$arr['fecha'],'total'=>$arr['total'],'credito'=>$arr['credito']);
        } 
}else{
    $fila[] = array('codv'=>'--', 'ca'=>'--', 'nombre'=>'--','apellidos'=>'--','lugar'=>'--','fecha'=>'--','total'=>'--','credito'=>'--');
}
?>

    <style>
    .fuente {
        font-family: 'Segoe UI light';
        color: red;
    }

    #tabla_pagos{
        width: 100%;
    }
/*    table.highlight>tbody>tr:hover {
        background-color: #a0aaf0 !important;
    }*/

    .borde_tabla {
        border: 1px solid;
        border-collapse: collapse !important;
    }

    .borde_tabla tr td, .borde_tabla tr th {

        border: 1px solid;
        border-collapse: collapse !important;
        padding-top:  1px;
        padding-bottom:  1px;
    }

    </style>
    <div class="row">
            <!-- <div class="mb-2"> -->
                <div class="col-md-2">
                    <b style= "color:blue"> Gestión:</b>
                    <select class="form-select" name="ges" id="ges" onchange="enviarges()">
                        <option value="0" selected disabled> Seleccionar</option>
                        <option value="2021"> 2021 </option>
                        <option value="2022"> 2022 </option>
                        <option value="2023"> 2023 </option>
                        <option value="2024"> 2024 </option>
                        <option value="2025"> 2025 </option>
                    </select>
                </div>
                <div class="col-md-8 offset-md-1">
                    <div><span class="fuente"><h3>Registro de ventas de la gestión: <?php echo $_GET['ges']?></h3></span></div>
                </div>
            <!-- </div> -->
    </div><br>

    
    <!-- TABLA -->
    <table id="tabla1" class="content-table table table-hover">
        <thead>
            <tr>
                <th>Código</th>
                <th>C.A.</th>
                <th>Lider/Experta</th>
                <th>Fecha de Venta</th>
                <th>Monto Total (Bs.)</th>
                <th>Tipo de Venta</th>
                <th>Ver</th>
                <!-- <th>Pagos</th> -->
                <th>Borrar</th>
                <th>Imprimir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($fila as $a  => $valor){ ?>
            <tr style='background-color: <?php if($valor["credito"] == 1){echo "#ffff9e";} if($valor["credito"] == 2){echo "#7eff9e";} ?>'>
                <td>
                    <?php echo $valor["codv"] ?>
                </td>
                <td>
                    <?php echo $valor["ca"] ?>
                </td>
                <td>
                    <?php echo $valor['nombre']." ".$valor['apellidos'] ?>
                </td>
                <td>
                    <?php echo $valor["fecha"]?>
                </td>
                <td>
                    <?php echo $valor["total"]?>
                </td>
                <td > <!-- style="text-align: center" -->
                    <?php if($valor["credito"] == "0"){echo "Contado";} else{echo "<button onclick='pagos(event, ".$valor['ca'].", `".$valor['nombre']."`, `".$valor['apellidos']."`)' type='button' class='btn btn-outline-primary btn-sm'>Ver pagos</button>";} ?>
                </td>
                <td>
                    <a href="#!" onclick="ver_venta('<?php echo $valor['codv']?>','<?php echo $valor['total']?>','<?php echo $valor['credito']?>','<?php echo $valor['ca']?>','<?php echo $valor['nombre'].' '.$valor['apellidos']?>'   )"><i class="material-icons">visibility</i></a>
                    <!-- <a href="#!"><i class="material-icons">build</i></a> -->
                </td>
                <td>
                    <!-- <a href="#!" onclick="borrar_venta('<?php echo $valor['codv'] ?>');"><i class="material-icons">delete</i></a> -->
                    <a href="#modal3" data-bs-toggle="modal" data-bs-target="#modal3" onclick="$('#codv').val('<?php echo $valor['codv'] ?>')"><i class="material-icons">delete</i></a>
                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="material-icons">delete</i></button> -->
                </td>
                <td>
                    <a href="#!" onclick="imprimir_detalle('<?php echo $valor['codv']?>','<?php echo $valor['total']?>','<?php echo $valor['credito']?>', '<?php echo $valor['lugar']?>','<?php echo $valor['ca']?>','<?php echo $valor['nombre'].' '.$valor['apellidos']?>')"><i class="material-icons">print</i></a>
                </td>
            </tr>
            <?php } ?>
            
        </tbody>
    </table>

<!-- Modal registro de venta detalle de venta -->
<div id="modal1" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <span id="_ca">Código arbell: </span><br>
                        <span id="lider_ex">Lider/Experta:</span>
                    </div>
                    <div class="col-sm-4" style="text-align: center;">
                        <span>Punto de venta: PRINCIPAL</span><br>
                        <span id="_credito">Forma de pago:</span><br>
                        <!-- <span id="_periodo">Periodo:</span> -->
                    </div>
                    <div class="col-sm-4" style="text-align:right">
                        <span>Distribuidora: CARMIÑA</span>
                    </div>
                    <div class="col-sm-12">
                        <p>
                            <h5>Items del comprobante</h5>
                        </p>
                    </div>

                    <div class="col-sm-12">
                        <table style="width: 100%" id="detalle_ven" class="borde_tabla">
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
                    <hr>
                    <div class="col-sm-4 offset-sm-8">
                        <h5>TOTALES:</h5>
                    </div>
                    <div class="col-sm-4 offset-sm-8">
                        <table class="borde_tabla">
                            <tr>
                                <th>Items:</th>
                                <td id="items"></td>
                            </tr>
                            <tr>
                                <th>Ganancias experta:</th>
                                <td id="gan_exp"></td>
                            </tr>
                            <tr>
                                <th>Total a pagar:</th>
                                <td id="total"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>  
        </div>
    </div>
</div>

<!-- MODAL ADMINISTRAR PAGOS -->
<div class="modal fade" id="modal2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Administrar pagos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <input id="codv_pago" type="text" hidden>
                <input id="_subtotal" type="text" hidden>
                <input id="_total" type="text" hidden>
                <input id="ca_pagos" type="text" hidden>
                <input id="nombres_pagos" type="text" hidden>

                <div class="row">
                    <div class="col-sm-5">
                        <div class="input-group mb-3">
                            <label for="nuevo_pago" class="input-group-text"><i class="material-icons"><img height="35px" src="https://img.icons8.com/plasticine/100/000000/money.png"/></i></label>
                            <input class="form-control" min="0" id="nuevo_pago" type="number" onkeypress="return check(event)" placeholder="Insertar nuevo pago">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <a href="#!" onclick="nuevo_pago()" id="boton_pagos" class="btn btn-primary btn-lg">Agregar pago</a>
                    </div>
                    <div class="col-sm-3">
                        <a href="#!" onclick="imprimir_pago()" id="print_pagos" class="btn btn-outline-success btn-lg"><i class="material-icons">print</i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="tabla_pagos" class="content-table">
                            <thead>
                                <tr>
                                    <th><h5>Fecha de pago</h5></th>
                                    <th><h5>Monto</h5></th>
                                    <th><center><h5>Borrar pago</h5></center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 offset-sm-8">
                        <b>
                            <p id="subtotal">Subtotal:</p>
                            <p style="color:red" id="debe">Saldo:</p>
                            <p id="saldo">Total:</p>
                        </b>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <a href="#!" id="btn-cerrar_modal2" class=" modal-action modal-close waves-effect waves-light btn green">Aceptar</a> -->
                <button id="btn-cerrar_modal2" type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                
            </div>
        </div>
    </div>
</div>


<!-- MODAL ELIMINAR VENTA  -->
    <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLabel">Se eliminará la venta.</h5> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-content">
                    <div class="container">
                        <input id="codv" type="text" value="codv" hidden>
                        <h4>Se eliminará la venta.</h4>
                        <span> Se devolveran los productos al inventario.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <a href="#!" class="modal-action modal-close waves-effect waves-light btn left red">Cancelar</a>
                    <a href="#!" onclick="borrar_venta()" class="modal-action modal-close waves-effect waves-light btn">Confirmar</a> -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="borrar_venta()" class="btn btn-primary" data-bs-dismiss="modal">Confirmar</button>
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
    // $('#modal').leanModal();
    // $('.modal_trigger_3').leanModal();
    
});
var mensaje = $("#mensaje");
mensaje.hide();

//FUNCION IMPRIMIR DETALLE DE VENTA
function imprimir_detalle(codv, total, credito, lugar, ca, cliente) {
    total = parseFloat(total).toFixed(2)
    var date = new Date();
    var options = {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    };

    date = date.toLocaleDateString("es-ES", options)


    detalle_venta(codv).then(respuesta => {

        var jsonParsedArray = JSON.parse(respuesta)
        let cantidad = 0
        let gan_exp = 0
        // let auxiliares = 0

        if (credito != 0) {credito = 'Crédito'}else{credito = 'Contado'}
        
        // $("#_periodo").html("Periodo: "+periodo)
        $("#_credito").html("Tipo de pago: "+credito)
        $("#_ca").html("Código Arbell: "+ca)
        $("#lider_ex").html("Lider/experta: "+cliente)

        //INSERTANDO FILAS A LA TABLA DETALLE DE VENTA 
        let filas = ""
        let table = document.getElementById("detalle_ven")
 
        for (key in jsonParsedArray) {
            if (jsonParsedArray.hasOwnProperty(key)) {


                filas = filas + `
                <tr>
                   <td>${jsonParsedArray[key]['codp']}</td>
                   <td>${jsonParsedArray[key]['linea']}</td>
                   <td>${jsonParsedArray[key]['descripcion']}</td>
                   <td>${jsonParsedArray[key]['cantidad']}</td>
                   <td>${parseFloat(jsonParsedArray[key]['pubs']).toFixed(2)} Bs.</td>
                   <td>${parseFloat(parseFloat(jsonParsedArray[key]['pubs_cd']).toFixed(1)).toFixed(2)}</td>
                   <td>${((parseInt(jsonParsedArray[key]['cantidad']) * parseFloat(parseFloat(jsonParsedArray[key]['pubs_cd'])).toFixed(1)).toFixed(2))} Bs.</td>
                </tr>
                `;

                gan_exp = gan_exp + (parseFloat(jsonParsedArray[key]['pubs']) * parseInt(jsonParsedArray[key]['cantidad']) - parseFloat(jsonParsedArray[key]['pubs_cd']) * parseInt(jsonParsedArray[key]['cantidad']))

                cantidad += parseInt(jsonParsedArray[key]['cantidad'])

                // if (jsonParsedArray[key]['codli'] == 16 || (jsonParsedArray[key]['codli'] >= 32 && jsonParsedArray[key]['codli'] <= 37)) {
                //     auxiliares += parseInt(jsonParsedArray[key]['cantidad']) 
                // }
            }
        }
        
    gan_exp = parseFloat(gan_exp).toFixed(1)
    gan_exp = parseFloat(gan_exp).toFixed(2)

    monto_v(codv).then(response => {
        let _monto
        console.log(response)
        var jsonMonto = JSON.parse(response)
        for (key in jsonMonto) {
            if (jsonMonto.hasOwnProperty(key)) {
                _monto = jsonMonto[key]['monto']
            }
        }
        _monto = parseFloat(parseFloat(_monto).toFixed(1)).toFixed(2)

        var miHtml = `<title>RECIBO</title>
        <style>
        .bod{
          font-family: 'Consolas';
        }
        .detalle, .detalle th, .detalle td {
          border: 1px solid black;
          border-collapse: collapse;
        }
     
      </style>
      <div class="bod">
      
        <span style="float:right">${date}</span>
        <br><br>

        <table width="100%" border="0">
          <tr>
            <td width="33%" align="left">
              <span>Código Arbell: ${ca}</span><br>
              <span>Lider/Experta: ${cliente}</span><br>
              <span>Lugar: ${lugar}</span>
            </td>
            <td width="33%" align="center">
              <span>Punto de venta: Principal</span><br>
              <span>Forma de pago: ${credito}</span><br>
            </td>
            <td width="33%" align="right">
              <span>Distribuidora: CARMIÑA</span>
            </td>
          </tr>
        </table>

      <br>
      
       <h4><b>Items del comprobante</b></h4>
       <table width="100%" class="detalle">
        <thead>
          <tr >
            <th >Código<br>(producto)</th>
            <th >Linea</th>
            <th >Descripción</th>
            <th >Cantidad</th>
            <th >P. Unidad (Bs.)</th>
            <th >P.Unidad C.D. (Bs.)</th>
            <th >Subtotal (Bs.)</th>
          </tr>
        </thead>
        <tbody>
          ${filas}
        </tbody>
       </table>
       <br>
     
      <div style="float: right">
       <h5>Totales:</h5>
      
         <table class="detalle">
          <tr>
            <td><b>Items:</b></td>
            <td>${cantidad} u.:</td>
          </tr>
          <tr>
            <td><b>G. experta:</b></td>
            <td>${gan_exp} Bs.</td>
          </tr>
          <tr>
            <td><b>Total:</b></td>
            <td>${_monto} Bs./${total} Bs.</td>
          </tr>
         </table>
       </div>
      </div>`;


            // $("#total").html(total +" Bs.")
            // $("#items").html(cantidad+"u. Incluye "+auxiliares+" auxiliares.")
            // $("#gan_exp").html(((gan_exp).toFixed(1))+" Bs.")
            // $("#modal1").openModal()

            imprimir(miHtml);
        })
    })
}

//OBTENER EL DETALLE DE VENTA EN JSON
function detalle_venta(codv) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "recursos/ventas/ver_venta.php?codv=" + codv,
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

//OBTENER MONTO DE PAGOS
function monto_v(codv) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "recursos/ventas/monto.php?codv="+codv,
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

/* funcion ver venta */
function ver_venta(codv, total, credito, ca, cliente) {
    detalle_venta(codv).then(respuesta => {
        var jsonParsedArray = JSON.parse(respuesta)
        let cantidad = 0
        let gan_exp = 0
        // let auxiliares = 0
        if (credito != 0) {credito = 'Crédito'}else{credito = 'Contado'}
        
        // $("#_periodo").html("Periodo: "+periodo)
        $("#_credito").html("Tipo de pago: "+credito)
        $("#_ca").html("Código Arbell: "+ca)
        $("#lider_ex").html("Lider/experta: "+cliente)

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

                
                gan_exp = gan_exp + (parseFloat(jsonParsedArray[key]['pubs']) * parseInt(jsonParsedArray[key]['cantidad']) - parseFloat(jsonParsedArray[key]['pubs_cd']) * parseInt(jsonParsedArray[key]['cantidad']))

                cantidad += parseInt(jsonParsedArray[key]['cantidad'])
                // if (jsonParsedArray[key]['codli'] == 16 || (jsonParsedArray[key]['codli'] >= 32 && jsonParsedArray[key]['codli'] <= 37)) {
                //     auxiliares += parseInt(jsonParsedArray[key]['cantidad']) 
                // }
            }
        }

        $("#total").html(total +" Bs.")
        $("#items").html(cantidad+"u.")
        $("#gan_exp").html(((gan_exp).toFixed(1))+" Bs.")
        $("#modal1").modal('toggle')
    })
}
//OBTENER EL DETALLE DE VENTA EN JSON
function detalle_venta(codv) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "recursos/ventas/ver_venta.php?codv=" + codv,
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

function imprimir(mihtml) {
    const $elementoParaConvertir = mihtml; // <-- Aquí puedes elegir cualquier elemento del DOM
    var ventana = window.open();
    ventana.document.write(mihtml);
    $(ventana.document).ready(function() {
        ventana.print();
        ventana.close();
    })
}

//ABRIR MODAL PAGOS CON TODOS LOS DATOS DE LA TABLA
function pagos(e, ca, nombre, apellidos) {
    

    $("#ca_pagos").val(ca)
    $("#nombres_pagos").val(nombre+" "+apellidos)

    document.getElementById("boton_pagos").setAttribute('onclick', "nuevo_pago()");
    $("#boton_pagos").removeClass('disabled')


    row = e.target.parentNode.parentNode
    cell = row.getElementsByTagName("td")
    $("#codv_pago").val(cell[0].innerText)
    ver_pagos(cell[0].innerText).then(respuesta => {
        let subtotal = 0
        $(".dinamic_rows").remove();
        var jsonParsedArray = JSON.parse(respuesta)
            for (key in jsonParsedArray) {
                if (jsonParsedArray.hasOwnProperty(key)) {
                    subtotal += parseFloat(jsonParsedArray[key]['monto'])
                    saldo = parseFloat(jsonParsedArray[key]['total'])
                }
            }
        $("#subtotal").html("Subtotal: "+subtotal+" Bs.")
        $("#debe").html("Saldo: "+(saldo-subtotal).toFixed(2)+" Bs.")
        $("#saldo").html("Total: "+subtotal+" Bs./"+saldo+" Bs.")

        $("#_subtotal").val(subtotal)
        $("#_total").val(saldo)

        if (subtotal >= saldo ) {
            $("#boton_pagos").addClass('disabled')
            document.getElementById('boton_pagos').removeAttribute("onclick");
        }

        //INSERTANDO FILAS A LA TABLA VER PAGOS
        let table = document.getElementById("tabla_pagos")
        for (key in jsonParsedArray) {
            if (jsonParsedArray.hasOwnProperty(key)) {
                let newTableRow = table.insertRow(-1)
                newTableRow.className = "dinamic_rows"
                newRow = newTableRow.insertCell(0)
                newRow.textContent = jsonParsedArray[key]['fecha_pago']

                newRow = newTableRow.insertCell(1)
                newRow.textContent = jsonParsedArray[key]['monto']+" Bs."

                newRow = newTableRow.insertCell(2)
                // newRow.innerHTML = '<a onclick="borrar_pago(event, '+jsonParsedArray[key]['id']+', '+jsonParsedArray[key]['codv']+')" class="btn-floating red"><i class="material-icons">delete</i></a>'
                newRow.innerHTML = '<center><button onclick="borrar_pago(event, '+jsonParsedArray[key]['id']+', '+jsonParsedArray[key]['codv']+')" class="btn btn-outline-danger btn-sm"><i class="material-icons">delete</i></button></center>'
            }
        }
    })

    // $("#modal2").openModal({dismissible: false})
    $("#modal2").modal('toggle')
}

//RECUPERAR DATOS DE LA BD TABLA: PAGOS(JSON)
function ver_pagos(codv) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "recursos/ventas/ver_pagos.php?codv="+codv,
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
//FUNCION PARA BORRAR UN PAGO DE LA BASE DE DATOS TABLA: PAGOS
function borrar_pago(e, id, codv) {
    console.log(id)
    $.ajax({
            url: "recursos/ventas/borrar_pago.php?id="+id+"&codv="+codv,
            method: "GET",
            success: function(response) {
                if(response){
                    let _sub = parseFloat($("#_subtotal").val())
                    let _monto_borrado = e.target.parentNode.parentNode.parentNode.children[1].innerHTML
                    _monto_borrado = parseFloat(_monto_borrado)
                    $("#_subtotal").val(_sub-_monto_borrado)
                    let nuevo_sub = parseFloat($("#_subtotal").val())
                    let total = parseFloat($("#_total").val())

                    $("#subtotal").html("Subtotal: "+nuevo_sub.toFixed(1)+" Bs.")
                    $("#debe").html("Saldo: "+parseFloat((total-nuevo_sub).toFixed(1)).toFixed(2)+" Bs.")
                    $("#saldo").html("Total: "+nuevo_sub.toFixed(1)+" Bs./"+total.toFixed(1)+" Bs.")
                    
                    let gest = "templates/ventas/reg_ventas.php?ges="+'<?php echo $_GET["ges"]?>'
                    mtoast("Pago eliminado", 'success')
                    document.getElementById("boton_pagos").setAttribute('onclick', "nuevo_pago()");
                    document.getElementById("boton_pagos").classList.remove("disabled");
                    $("#btn-cerrar_modal2").attr('onclick', '$("#cuerpo").load("'+gest+'")');
                }else{
                    console.log("error: "+response)
                }

            },
            error: function(error) {
                console.log(error)
            }
    })
    e.target.parentNode.parentNode.parentNode.remove()
}

//FUNCION PARA INSERTAR UN NUEVO PAGO
function nuevo_pago() {

    if ($('#nuevo_pago').val().length == 0) {
        return mtoast("Debe ingresar un pago válido.", 'warning')
    }
    if ($("#nuevo_pago").val() < 1) {
        return mtoast("Debe ingresar un pago mayor a 0", 'warning')
    }


    let codv = $("#codv_pago").val()
    let monto = parseFloat($("#nuevo_pago").val()) 
    $("#nuevo_pago").val("")
    let subtotal = parseFloat($("#_subtotal").val())
    let total = parseFloat($("#_total").val())
    if (subtotal+monto > total ) {return mtoast("La suma de los pagos excede el total.", 'danger')}

    

    $.ajax({
        url: "recursos/ventas/nuevo_pago.php?codv="+codv+"&monto="+monto,
        method: "GET",
        success: function(response) {
            respuesta = JSON.parse(response)
            monto_ = parseFloat(respuesta.monto)
            nuevo_sub = subtotal+monto_
            $("#_subtotal").val(nuevo_sub)
            if (nuevo_sub >= total) {
                $("#boton_pagos").addClass('disabled')
                document.getElementById('boton_pagos').removeAttribute("onclick");
            }
            
            let table = document.getElementById("tabla_pagos")
            let newTableRow = table.insertRow(-1)
            newTableRow.className = "dinamic_rows"
            newRow = newTableRow.insertCell(0)
            newRow.textContent = respuesta.fecha_pago

            newRow = newTableRow.insertCell(1)
            newRow.textContent = respuesta.monto +" Bs."

            newRow = newTableRow.insertCell(2)
            newRow.innerHTML = '<button onclick="borrar_pago(event, '+respuesta.id+', '+respuesta.codv+')" class="btn btn-outline-danger btn-sm"><i class="material-icons">delete</i></button>'
            mtoast("Pago agregado.", 'success')

            let gest = "templates/ventas/reg_ventas.php?ges="+'<?php echo $_GET["ges"]?>'

            console.log(total, nuevo_sub)
            console.log(total.toFixed(1), nuevo_sub.toFixed(1))

            $("#subtotal").html("Subtotal: "+(nuevo_sub)+" Bs.")
            $("#debe").html("Saldo: "+(parseFloat((total-nuevo_sub).toFixed(1))).toFixed(2)+" Bs.")
            $("#saldo").html("Total: "+nuevo_sub+" Bs./"+total+" Bs.")
            $("#btn-cerrar_modal2").attr('onclick', '$("#cuerpo").load("'+gest+'")')

        },
        error: function(error) {
            console.log(error)
        }
    })
}

//funcion borrar venta
function borrar_venta(){
let codv = $("#codv").val()
$.ajax({
    url: "recursos/ventas/borrar_venta.php?codv="+codv,
    method: "GET",
    success: function (response){
        console.log(response);
        if (response) {
            mtoast("Venta eliminada.", 'success')
            $("#cuerpo").load("templates/ventas/reg_ventas.php")
        }
    }

});
}

function imprimir_pago() {
    var date = new Date();
    var options = {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    };
    date = date.toLocaleDateString("es-ES", options)

    let codv = $("#codv_pago").val()
    let ca = $("#ca_pagos").val()
    let nombres = $("#nombres_pagos").val()
    let array_ = ""
    let subtotal = 0
    ver_pagos(codv).then(respuesta => {
        let jsonParsedArray = JSON.parse(respuesta)
        for (key in jsonParsedArray) {
            subtotal += parseFloat(jsonParsedArray[key]['monto'])
            if (jsonParsedArray.hasOwnProperty(key)) {

                let fila = `
                <tr style="text-align: center">
                    <td>${jsonParsedArray[key]["monto"]}</td>
                    <td>${jsonParsedArray[key]["fecha_pago"]}</td>
                </tr>`
                array_ = array_ + fila
            }
        }
        // console.log(array_)
    var miHtml = `<title>RECIBO</title>

  <style>
    .bod{
      font-family: 'Consolas';
    }
    .detalle, .detalle th, .detalle td {
      border: 1px solid black;
      border-collapse: collapse;
    }
 
  </style>
  <div class="bod">
  
    <span style="float:right">${date}</span>
    <br><br>

    <table width="100%" border="0">
      <tr>
        <td width="33%" align="left">
          <span>Código Arbell: ${ca}</span><br>
          <span>Lider/Experta: ${nombres}</span><br>
        </td>
        <td width="33%" align="center">
          <span>Punto de venta: Principal</span><br>
          <span>Forma de pago: Crédito</span><br>
        </td>
        <td width="33%" align="right">
          <span>Distribuidora: CARMIÑA</span>
        </td>
      </tr>
    </table>

  <br>
  
   <h4><b>Comprobante de pagos</b></h4>
   <table width="100%" class="detalle">
    <thead>
      <tr >
        <th center>Monto</th>
        <th center>Fecha de pago</th>
      </tr>
    </thead>
    <tbody>
      ${array_}
    </tbody>
   </table>
   <br>
 
  <div style="float: right">
   <h5>Totales:</h5>
  
     <table class="detalle">
      <tr>
        <td><b>Total:</b></td>
        <td>${subtotal}/${jsonParsedArray[0]['total']}</td>
      </tr>
     </table>
   </div>
  </div>`;

    var ventana = window.open();
    ventana.document.write(miHtml);
    ventana.print();
    ventana.close();
    })
    
}

//funcion gestión
function enviarges() {
    ges = $('#ges').val();
    console.log(ges)
    $("#cuerpo").load("templates/ventas/reg_ventas.php?ges="+ges);
}
</script>

