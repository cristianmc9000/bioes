<?php
require('../../recursos/conexion.php');
require('../../recursos/sesiones.php');
session_start();
date_default_timezone_set("America/La_Paz");
$year = date('Y');
if (isset($_GET["ges"])) {
  $year = $_GET["ges"];
}

$result = $conexion->query("SELECT valor FROM cambio WHERE id = 2");
$result = $result->fetch_all(MYSQLI_ASSOC);

$Sql = "SELECT a.id, a.ca, CONCAT(c.nombre,' ',c.apellidos) as cliente, a.fecha, a.total, a.total_cd, a.descuento, a.valor_peso, a.credito FROM pedidos a, clientes c WHERE a.ca = c.CA AND a.estado = 1 AND a.fecha LIKE '".$year."%'";

// $_SESSION['periodo'] = $per;
//consulta tabla inventario

$Busq = $conexion->query($Sql); 

if((mysqli_num_rows($Busq))>0){
    while($arr = $Busq->fetch_array()){ 
        $fila[] = array('id'=>$arr['id'], 'ca'=>$arr['ca'], 'cliente'=>$arr['cliente'], 'fecha'=>$arr['fecha'], 'total'=>$arr['total'], 'total_cd'=>$arr['total_cd'], 'descuento'=>$arr['descuento'], 'valor_peso'=>$arr['valor_peso'], 'credito'=>$arr['credito']); 
    }
}else{
        $fila[] = array('id'=>'---', 'ca'=>'---', 'cliente'=>'---', 'fecha'=>'---', 'total'=>'---', 'total_cd'=>'---', 'descuento'=>'---', 'valor_peso'=>'---', 'credito'=>'---');
}
?>

<style>

@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap');
.roboto{
    font-family: 'Segoe UI Light'
    /*font-family: 'Roboto', sans-serif;*/
}
.fuente{
    color: red;
}
.fuente_azul{
    color: black;
}

#detalle_ped th, #detalle_ped tr td{
    border:  1px solid;
}

.line div{
    line-height: 1px;
    display: flex;
    flex-direction: row;
    gap: 20px;
}
.line div p{
    width: calc(50% - 20px);
}

.lineh{
    line-height: 1px;
}
</style>

<div class="row">
    <div class="col-md-2">
        <b style= "color:blue"> Gestión:</b>
        <select onchange="enviarfecha()" name="ges" id="ges" class="form-select" aria-label="Default select example">
            <option value="<?php echo $year ?>" selected disabled><?php echo $year?></option>
            <option value="2022"> 2022 </option>
            <option value="2023"> 2023 </option>
            <option value="2024"> 2024 </option>
            <option value="2025"> 2025 </option>
            <option value="2026"> 2026 </option>
            <option value="2027"> 2027 </option>
        </select>
    </div>
    <div class="col-md-8 text-center">

            <span class="fuente">
                <h3>
                    Pedidos: Gestión - <?php echo $year;?>
                </h3>
            </span>
            <div class="" style="">
                <a href="#!" id="cambio" style="background-color: #bdc3c7;" class="btn btn-flat waves-light waves-effect"><?php echo $result[0]['valor'] ?> Bs.</a>
            </div>

    </div>

</div>
<br>
<div class="row">
<div class="col-md-11">
<!-- TABLA -->
<table id="tabla1" class="content-table table table-hover text-center">
    <thead >
        <tr class="text-center">
            <th>Código</th>
            <th>CA</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Tipo pago</th>
            <th>Total</th>

            <th>Aceptar pedido</th>
            <th>Rechazar pedido</th>
        </tr>
    </thead>

<tbody>
    <?php foreach($fila as $a  => $valor){ ?>
        <tr <?php if($valor["credito"] == '1'){echo 'style="background-color: #ffff9e"';}?>>
            <td><?php echo $valor["id"] ?></td>
            <td><?php echo $valor["ca"]?></td>
            <td><?php echo $valor["cliente"]?></td>
            <td><?php echo $valor["fecha"]?></td>
            <td><?php if($valor["credito"] == '1'){echo 'Crédito';}else{echo 'Contado';} ?></td>
            <td><?php echo $valor["total_cd"]?> Bs.</td>

            <td>
            <a href="#!" onclick="aceptar_pedido('<?php echo $valor['id']?>', '<?php echo $valor['ca']?>', '<?php echo $valor['cliente']?>', '<?php echo $valor['credito']?>', '<?php echo $valor['valor_peso']?>', '<?php echo $valor['descuento']?>', event)"><i class="material-icons">check_circle</i></a>
            <!-- <a href="#!"><i class="material-icons">build</i></a> -->
            </td>
            <td>
            <a href="#!" onclick="rechazar_pedido('<?php echo $valor['id'] ?>');"><i class="material-icons">remove_shopping_cart</i></a>
            </td>

        </tr>
    <?php } ?>  
</tbody>
</table>

<!--MODAL MODIFICAR INVENTARIO-->
<div id="modal1" class="modal fade roboto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detalle del pedido</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <input type="text" id="id_ped" hidden>
        <div class="row">
            <div class="col-sm-12 line">
                <div>
                    <p id="det_ca"></p>
                    <p id="det_cli"></p>
                </div>
                <div>
                    <p id="det_cred"></p>
                    <p id="det_desc"></p>
                </div>
                <div>
                    <p id="det_total"></p>
                    <p id="det_total_cd"></p>
                </div>
            </div>

            <div class="col-sm-12">
                <table id="detalle_ped" class="highlight striped centered"> <!-- class="borde_tabla" -->
                    <thead>
                        <tr>
                            <th>Código <br> (producto)</th>
                            <th>Linea</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Subtotal C/D</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody class="centered"></tbody>
                </table>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button href="#!" id="reg_ped" class="btn btn-primary">Aceptar pedido</button>
        </div>
    </div>
</div>
</div>



<!--MODAL BORRAR CLIENTE-->
<div class="row">
<div id="modal2" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4><b>Borrar Producto</b></h4>  
    <p>¿Esta seguro que desea eliminar este producto del inventario?</p>
    <div class="row">
      <form class="col s12" id="eliminar_inventario">
          <div class="row">
            <div class="input-field col s6" >
              <input id="datos_borrar" name="id" type="text" hidden>
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

<!-- Modal Structure -->
  <div id="modal3" class="modal fade roboto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Valor de cambio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="input-group mb-3">
                  <span class="input-group-text">$1 Peso = </span>
                  <input id="_cambio" type="text" class="form-control" value="<?php echo $result[0]['valor'] ?>">
                  <span class="input-group-text">Bs.</span>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button href="#!" id="set_value" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </div>
  </div>


<div class="row">
    <div id="modal4" class="modal roboto col s4 offset-s4">
        <div class="modal-content">
          <h4>Se rechazará el pedido seleccionado.</h4>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-light btn red left">Cerrar</a>
            <a href="#!" id="del_ped" class="waves-effect waves-light btn">Aceptar</a>
        </div>
    </div>
</div>

</div>
</div>


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

    // $('.modal').leanModal();

});

let sw = 1;

let evento
function aceptar_pedido(id, ca, cliente, credito, valor_peso, descuento, e) {
    evento = e;
    if (credito == '1') {
        credito = 'Crédito'
    }else{
        credito = "Contado"
    }

    let total 
    let total_cd 

    $.ajax({
        url: "recursos/pedidos/detalle.php?id="+id,
        method: "GET",
        success: function(response) {

            let cantidad = 0;
            let auxiliares = 0;
            var jsonParsedArray = JSON.parse(response)
            //INSERTANDO FILAS A LA TABLA DETALLE DE PEDIDO
            let table = document.getElementById("detalle_ped")
            $(".dinamic_rows").remove();
            for (key in jsonParsedArray) {
                if (jsonParsedArray.hasOwnProperty(key)) {
                    let newTableRow = table.insertRow(-1)
                    newTableRow.className = "dinamic_rows"
                    
                    let estilos = "";
                    let mod = `<a href='#' class="del_btn" style='color: red' onclick='del_row("${jsonParsedArray[key]['id']}", "${id}","${jsonParsedArray[key]['pubs']}","${jsonParsedArray[key]['pubs_desc']}", ${jsonParsedArray[key]['cantidad']},event)'><i class='material-icons'>delete</i></a><small>Eliminar</small>`;

                    if (jsonParsedArray[key]['estado'] == '0') {
                        estilos = "text-decoration: line-through; color: #636e72";
                        mod = `<a href='#' class="del_btn" style='color: #2ecc71' onclick='restore_row("${jsonParsedArray[key]['id']}", "${id}", "${jsonParsedArray[key]['pubs']}","${jsonParsedArray[key]['pubs_desc']}", ${jsonParsedArray[key]['cantidad']},event)'><i class='material-icons'>restore_from_trash</i></a><small>Restaurar</small>`;
                    }

                    newRow = newTableRow.insertCell(0)
                    newRow.style = estilos
                    newRow.textContent = jsonParsedArray[key]['id']

                    newRow = newTableRow.insertCell(1)
                    newRow.style = estilos
                    newRow.textContent = jsonParsedArray[key]['linea']

                    newRow = newTableRow.insertCell(2)
                    newRow.style = estilos
                    newRow.textContent = jsonParsedArray[key]['descripcion']

                    newRow = newTableRow.insertCell(3)
                    newRow.style = estilos
                    newRow.textContent = jsonParsedArray[key]['cantidad']

                    newRow = newTableRow.insertCell(4)
                    newRow.style = estilos
                    newRow.textContent = jsonParsedArray[key]['pubs'] +" Bs."

                    newRow = newTableRow.insertCell(5)
                    newRow.style = estilos
                    newRow.textContent = jsonParsedArray[key]['pubs_desc'] +" Bs."

                    newRow = newTableRow.insertCell(6)
                    newRow.className = 'center lineh'
                    newRow.innerHTML = mod;

                    
                    // gan_exp = gan_exp + (parseFloat(jsonParsedArray[key]['pubs']) * parseInt(jsonParsedArray[key]['cantidad']) - parseFloat(jsonParsedArray[key]['pubs_cd']) * parseInt(jsonParsedArray[key]['cantidad']))
                    // total_cd += parseFloat(jsonParsedArray[key]['pubs_desc'])

                    cantidad += parseInt(jsonParsedArray[key]['cantidad'])
                    if (jsonParsedArray[key]['codli'] == '11') {
                        auxiliares += parseInt(jsonParsedArray[key]['cantidad']) 
                    }
                }
            }
            get_total(id).then(response=>{
                total = response[0].total
                total_cd = response[0].total_cd

                let json = [id, ca, credito, total_cd, valor_peso, descuento]
                let _desc = 0;
                if (descuento == '2') {
                    _desc = 30;
                }

                document.getElementById("id_ped").value = JSON.stringify(json)

                document.getElementById("det_ca").innerHTML = "<b>Código arbell: </b>"+ca
                document.getElementById("det_cli").innerHTML = "<b>Cliente: </b>"+cliente
                document.getElementById("det_desc").innerHTML = "<b>Descuento: </b>"+_desc+"%"
                document.getElementById("det_cred").innerHTML = "<b>Tipo pago: </b>"+credito
                document.getElementById("det_total").innerHTML = "<b>Total: </b>"+total+" Bs."
                document.getElementById("det_total_cd").innerHTML = "<b>Total C/D: </b>"+total_cd+" Bs."
                $("#modal1").modal('toggle');
            })
            
        },
        error: function(error) {
            console.log(error)
        }
    });
}

function del_row(codp, id, pubs, pubs_cd, cant, e) {
    
    if (sw == 0) {
        console.log("espera...")
        return false;
    }
    sw = 0;

    let total_cd_table_cell = evento.target.parentNode.parentNode.parentNode.cells[5]
    get_total(id).then(response=>{
        let total = parseFloat(response[0].total) - (parseFloat(pubs)*parseInt(cant))
        let total_cd = parseFloat(response[0].total_cd) - (parseFloat(pubs_cd)*parseInt(cant))

        let json = document.getElementById("id_ped").value
        json = JSON.parse(json)
        json[3] = total_cd
        document.getElementById("id_ped").value = JSON.stringify(json)

        $.ajax({
            url: "recursos/pedidos/mod_item.php?codp="+codp+"&id="+id+"&estado=0",
            method: "GET",
            success: function(response) {
                if (response) {
                    let row = e.target.parentNode.parentNode.parentNode;
                    for (var i = 0; i < row.cells.length-1; i++) {
                        row.cells[i].style.textDecoration = "line-through";
                        row.cells[i].style.color = "#636e72"; 
                    }
                        
                    let cell = e.target.parentNode.parentNode    
                    cell.innerHTML = `<a href='#' class="del_btn" style='color: #2ecc71' onclick='restore_row("${codp}", "${id}", "${pubs}", "${pubs_cd}", "${cant}", event)'><i class='material-icons'>restore_from_trash</i></a><small>Restaurar</small>`
                    cell.style.textDecoration = 'none';

                    document.getElementById("det_total").innerHTML = "<b>Total: </b>"+total.toFixed(1)+" Bs."
                    document.getElementById("det_total_cd").innerHTML = "<b>Total C/D: </b>"+total_cd.toFixed(1)+" Bs."

                    total_cd_table_cell.innerHTML = `${total_cd.toFixed(1)} Bs.`
                        
                    sw = 1;

                }

            },
            error: function(error) {
                console.log(error)
            }
        })
    })

}

function restore_row(codp, id, pubs, pubs_cd, cant, e) {

    if (sw == 0) {
        console.log("espera...")
        return false;

    }
    sw = 0;

    let total_cd_table_cell = evento.target.parentNode.parentNode.parentNode.cells[5]
    get_total(id).then(response=>{
        let total = parseFloat(response[0].total) + (parseFloat(pubs)*parseInt(cant))
        let total_cd = parseFloat(response[0].total_cd) + (parseFloat(pubs_cd)*parseInt(cant))

        let json = document.getElementById("id_ped").value
        json = JSON.parse(json)
        json[3] = total_cd
        document.getElementById("id_ped").value = JSON.stringify(json)

        $.ajax({
            url: "recursos/pedidos/mod_item.php?codp="+codp+"&id="+id+"&estado=1",
            method: "GET",
            success: function(response) {
                console.log(response)
                if (response) {
                    let row = e.target.parentNode.parentNode.parentNode;
                    for (var i = 0; i < row.cells.length-1; i++) {
                        row.cells[i].style.textDecoration = "none";
                        row.cells[i].style.color = "#000"; 
                    }
                        
                    let cell = e.target.parentNode.parentNode;    
                    cell.innerHTML = `<a href='#' class="del_btn" style='color: red' onclick='del_row("${codp}", "${id}", "${pubs}", "${pubs_cd}", "${cant}", event)'><i class='material-icons'>delete</i></a><small>Eliminar</small>`;
                    cell.style.textDecoration = 'none';

                    document.getElementById("det_total").innerHTML = "<b>Total: </b>"+total.toFixed(1)+" Bs."
                    document.getElementById("det_total_cd").innerHTML = "<b>Total C/D: </b>"+total_cd.toFixed(1)+" Bs."

                    total_cd_table_cell.innerHTML = `${total_cd.toFixed(1)} Bs.`

                    sw = 1;
                }

            },
            error: function(error) {
                console.log(error)
            }
        })
    })
}

const get_total = async (id) => {
try{
    const resp = await fetch("recursos/pedidos/get_total.php?id="+id)
    const res = await resp.json()
    return res
}
    catch(error){
        console.log(error)
    }
}

document.getElementById('cambio').addEventListener('click', () => {
    $("#modal3").modal('toggle')
});
document.getElementById('set_value').addEventListener('click', () => {
    let cambio = document.getElementById("_cambio").value;
    $.ajax({
        url: "recursos/pedidos/cambio.php?valor="+cambio,
        method: "GET",
        success: function(response) {
            console.log(response)
            $("#modal3").modal('toggle');
            $("#cuerpo").load("templates/pedidos/pedidos.php");
        },
        error: function(error) {
            console.log(error)
        }
    })
});

document.getElementById('reg_ped').addEventListener('click', () => {
    // let array_
    let id = document.getElementById("id_ped").value
    id = JSON.parse(id)
    
    // let id_pedido = id[0];
    let total_cd = id[3]
    let descuento = id[5]
    let valor = id[4]
    let ca = id[1]
    let tipo_pago = id[2]
    let pago_inicial = "0";
    
    if (tipo_pago == "Contado") {
        tipo_pago = "0";
    }else{
        tipo_pago = "1";
    }


            $.ajax({
                url: "recursos/pedidos/check_stock.php?id="+id[0],
                method: "GET",
                success: function(item) {
                    if (item != '1') {
                        item = JSON.parse(item)
                        return mtoast("Cantidad del producto: "+item.codpro+" insuficiente en stock, "+item.stock+" disponibles.", 'warning')
                    }
                    
                    $.ajax({
                        url: "recursos/pedidos/detalle.php?id="+id[0]+"&x=1",
                        method: "GET",
                        success: function(resp) {
                            // return console.log(resp)
                            if (resp == 'nodata') {
                                return mtoast('El pedido no contiene productos', 'warning');
                            }
                            resp = JSON.parse(resp)
                            resp.push({total_cd: total_cd})
                            // resp.push({_descuento: descuento})
                            resp.push({_valor: valor})
                            resp.push({_ca: ca})
                            resp.push({_tipo_pago: tipo_pago})
                            resp.push({_pago_inicial: pago_inicial})
                            // return console.log(resp)
                            $.ajax({
                                url: "recursos/ventas/registrar_venta.php",
                                data: {
                                    "json": JSON.stringify(resp)
                                },
                                method: "post",
                                success: function(response) {
                                    return console.log(response)
                                    $("#modal1").modal('toggle')
                                    $("#cuerpo").load("templates/pedidos/pedidos.php")
                                    mtoast("El pedido fué registrado.", 'success')
                                },
                                error: function(error) {
                                    console.log(error)
                                }
                            });
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                },
                error: function(error) {
                    console.log(error)
                }
            });

});
function rechazar_pedido(id) {
    document.getElementById('id_ped').value = id
    $("#modal4").openModal()
}

document.getElementById('del_ped').addEventListener('click', () => {
    let id = document.getElementById('id_ped').value
    $.ajax({
        url: "recursos/pedidos/rechazar.php?id="+id,
        method: "GET",
        success: function(response) {
            // console.log(response)
            $("#modal4").closeModal();
            Materialize.toast("El pedido fué rechazado.", 4000);
            $("#cuerpo").load("templates/pedidos/pedidos.php");
        },
        error: function(error) {
            console.log(error)
        }
    });    
})

//funcion periodo
function enviarfecha() {
    ges = $('#ges').val();
    $("#cuerpo").load("templates/pedidos/pedidos.php?ges="+ges);
}

</script>


