<?php 
	require('../../recursos/conexion.php');
	session_start();
	$ca= "";
    $sw = 0;
    if (isset($_GET['ca'])) {
        $ca = $_GET['ca'];
        $sw = 1;
    }else{
        $ca = $_SESSION["ca"];
    }
	date_default_timezone_set("America/La_Paz");
	$year = ""; 
	if (isset($_GET["ges"])) {
		$year = $_GET['ges'];
	}else{
		$year = date("Y");
	}
	$result = $conexion->query("SELECT * FROM pedidos WHERE estado != 0 AND estado != 2 AND ca=".$ca." AND fecha LIKE '%".$year."%' ORDER BY fecha DESC");
	$res = $result->fetch_all(MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0) {
        $res[0]['codv'] = '';
    }

    $result2 = $conexion->query("SELECT * FROM ventas WHERE estado = 1 AND ca=".$ca."  AND fecha LIKE '%".$year."%' ORDER BY fecha DESC");
    // SELECT * FROM ventas WHERE estado = 1 AND codp != 'NULL' AND ca=".$ca."  AND fecha LIKE '%".$year."%' ORDER BY fecha DESC
    $res2 = $result2->fetch_all(MYSQLI_ASSOC);

    if ($result2) {

        $arr = array();
            foreach($res2 as $valor2){
  
                    $arr['id'] = $valor2['codp'];
                    $arr['codv'] = $valor2['codv'];
                    $arr['ca'] = $valor2['ca'];
                    $arr['fecha'] = $valor2['fecha'];
                    $arr['total_cd'] = $valor2['total'];
                    // $arr['descuento'] = $valor2['descuento'];
                    $arr['valor_peso'] = $valor2['valor_peso'];
                    $arr['credito'] = $valor2['credito'];
                    // $arr['periodo'] = $valor2['periodo'];
                    $arr['estado'] = '2';
                    array_push($res, $arr);
            }
    }
    // echo var_dump($result[0]['total_cd']);
    $no_result = "";
    // echo var_dump($res);
	if (!$res2 && !$res) {
        $no_result = "<div class='valign-wrapper' style='height: 60vh;'><h1 class='roboto center'>No tienes un historial de compras.</h1></div>";
		// echo var_dump($result[0]['ca']);
	}
	
?>
<style>
.card__img {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
</style>
<br>
<div class="container">
    <div class="row">
        <select onchange="enviarfecha()" class="browser-default" name="ges" id="ges">
            <option value="<?php echo $year ?>" selected disabled><?php echo $year?></option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
        </select>
        <br>

        <?php echo $no_result; ?>

        <?php foreach($res as $key  => $valor){ ?>
        <div class="col s12 m6 l6 xl6 rubik">

            <div class="z-depth-3 card horizontal card__pad"
                <?php if ($valor['estado'] == '1') {echo 'style="background-color: #f1c40f"';}elseif($valor['credito'] == 1){echo 'style="background-color: #ff7979"';}else{echo 'style="background-color: #2ecc71"';}?>>
                <div class="card-stacked">
                    <div class="">
                        <p>Estado: <?php if($valor['estado'] == '1'){echo 'Pendiente';}else{echo 'Aceptado';} ?></p>
                        <p>Tipo de pago: <?php if ($valor['credito']=='1' || $valor['credito']=='2') {echo 'Crédito';}else{echo 'Contado';}?></p>
                        <p>
                            <div class="dd"><?php echo $valor['fecha']; ?></div>
                        </p>

                        <p style="position: absolute; bottom: 0px; "><b>Total:
                            </b><?php echo 'Bs. '.$valor['total_cd']; ?></p>
                    </div>
                </div>
                <div class="card__img">
                    <div><a onclick="detalle('<?php echo $valor['id'] ?>', '<?php echo $valor['estado'] ?>', `<?php echo $valor['codv'] ?>`)" style="width: 100%"
                            class="btn waves-effect waves-dark white black-text">Detalle</a></div>
                    <div <?php if ($valor['estado'] == '1' || $valor['credito'] == '0') {echo 'hidden';}?>><a onclick="pagos('<?php echo $valor['id'] ?>', '<?php echo $valor['credito'] ?>', '<?php echo $valor['total_cd'] ?>', '<?php echo $valor['codv'] ?>')"
                            style="width: 100%" class="btn waves-effect waves-dark white black-text">Pagos</a></div>

                    <!-- <img class=" img__card" src="images/arbell_logo.png"> -->
                </div>
            </div>
        </div>
        <?php } ?>
    </div>


        <div id="modal_historial_pagos"  style="" class="modal rubik">
            <div class="modal-content">
                <h4>Historial de pagos</h4>

                <table id="pagos" class="det content-table z-depth-4">
                    <thead>
                        <tr>
                            <th>Fecha de pago</th>
                            <th>Monto</th>
                            <!-- <th>PRECIO</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2" class="dinamic_rows">No se ha realizado ningún pago...</td>
                        </tr>
                    </tbody>
                </table>

                <br>
                <div>
                    <p id="saldo"></p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
            </div>
        </div>

        <div id="modal_historial_detalle" class="modal rubik">
            <a href="#!" class="modal-close waves-effect waves-light btn-small right"><i class="material-icons"><b>close</b></i></a>
            <div class="modal-content">
                <input type="text" id="historial_codigo_pedido" hidden>
                <h4>Detalle del pedido</h4>
                <br>
                <div>
                    <table id="detalle" class="det centered content-table z-depth-4">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Cant.</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <div id="div_historial_cancelar_pedido" class="center"><a id="historial_cancelar_pedido" class="waves-effect waves-light red btn" hidden>Cancelar pedido</a></div>
            </div>
        </div>

        <div id="modal_conf_cancelar_pedido" class="modal rubik">
            <a href="#!"  class="modal-close waves-effect waves-light red btn-small right"><b><i class="material-icons">close</i></b></a>
            <div class="modal-content">
                <h4>Se cancelará el pedido seleccionado.</h4>
                <br>

            </div>
            <br>
            <div class="modal-footer">
                <div class="center">
                    <a href="#!" id="conf_historial_cancelar_pedido" class="waves-effect waves-light btn">Confirmar</a>
                </div>
            </div>
        </div>



</div>
<script>
$(document).ready(function() {
    $('.modal').modal();
    $("#titulo").html('Historial');
    var options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    };
    document.querySelectorAll('.dd').forEach(function(e) {
        fecha = new Date(e.innerText);
        e.innerText = fecha.toLocaleDateString("es-ES", options);;
    });

    if (`<?php echo $sw ;?>` == '1') {
        document.getElementById('menu').hidden = true;
        document.getElementById('back_expertas').hidden = false;
    }

});

function pagos(id, credito, total_cd, codv) {
    if (credito == '1' || credito == '2'){
        $(".dinamic_rows").remove();
        $.ajax({
            url: "recursos/catalogos/pagos.php?id="+id+"&codv="+codv,
            method: "GET",
            success: function(response) {
                // return console.log(response);
                res = JSON.parse(response)
                //INSERTANDO FILAS A LA TABLA VER PAGOS
                let table = document.getElementById("pagos")
                let subtotal = 0;
                if (res.length < 1) {
                    $("#pagos tbody").html(
                        '<tr><td colspan="2" class="dinamic_rows">No se ha realizado ningún pago...</td></tr>'
                    );
                } else {
                    for (key in res) {
                        if (res.hasOwnProperty(key)) {
                            let newTableRow = table.insertRow(-1)
                            newTableRow.className = "dinamic_rows"
                            newRow = newTableRow.insertCell(0)
                            let date = new Date(res[key]['fecha_pago'])
                            newRow.textContent = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date
                                .getFullYear();

                            newRow = newTableRow.insertCell(1)
                            newRow.textContent = res[key]['monto'] + " Bs."

                            subtotal += res[key]['monto'];

                        }
                    }
                }
                document.getElementById('saldo').innerHTML =
                    `Saldo pendiente: ${(parseFloat(total_cd)-parseFloat(subtotal)).toFixed(1)}`;
                $("#modal_historial_pagos").modal('open')
            },
            error: function(error) {
                console.log(error)
            }
        })
    } else {

    }

}

function detalle(id, estado, codv) {
    // console.log(id, codv)
    document.getElementById('historial_codigo_pedido').value = id;
    if (estado == '2') {
        document.getElementById('div_historial_cancelar_pedido').hidden = true;
    }else{
        document.getElementById('div_historial_cancelar_pedido').hidden = false;
    }

    $(".dinamic_rows").remove();
    $.ajax({
        url: "recursos/catalogos/detalle.php?id="+id+"&codv="+codv,
        method: "GET",
        success: function(response) {
            res = JSON.parse(response)
            // console.log(res.length)
            let table = document.getElementById("detalle")
            for (key in res) {
                if (res.hasOwnProperty(key)) {
                    let newTableRow = table.insertRow(-1)
                    newTableRow.className = "dinamic_rows"
                    newRow = newTableRow.insertCell(0)
                    newRow.textContent = res[key]['codpro']

                    newRow = newTableRow.insertCell(1)
                    newRow.textContent = res[key]['descripcion']

                    newRow = newTableRow.insertCell(2)
                    newRow.textContent = res[key]['cant']

                    newRow = newTableRow.insertCell(3)
                    newRow.textContent = res[key]['pubs_cd'] + " Bs."
                }
            }

            $("#modal_historial_detalle").modal('open')
        },
        error: function(error) {
            console.log(error)
        }
    })
}

document.getElementById('historial_cancelar_pedido').addEventListener('click', () => {
    let instance = M.Modal.getInstance(document.getElementById('modal_conf_cancelar_pedido'))
    instance.open();
})

document.getElementById('conf_historial_cancelar_pedido').addEventListener('click', () => {
    var cod = document.getElementById('historial_codigo_pedido').value;
    let ca = `<?php echo $ca ;?>`

    fetch('recursos/catalogos/cancel_ped.php?cod='+cod)
    .then(response => response.text())
    .then(data => {
        if (data == '11') {
            $("#modal_conf_cancelar_pedido").modal('close');
            $("#modal_historial_detalle").modal('close');
            M.toast({html: 'Se ha cancelado el pedido.', displayLength: 3000})
            $("#cuerpo").load('templates/catalogos/historial.php?ca='+ca);
        }else{
            console.log('error');
        }
    })
})

function enviarfecha() {
    let ges = $('#ges').val();
    let ca = `<?php echo $ca; ?>`; 
    $("#cuerpo").load("templates/catalogos/historial.php?ges="+ges+"&ca="+ca);
}
</script>