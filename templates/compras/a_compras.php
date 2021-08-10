<?php 
  session_start();
?>
<style type="text/css">
    .ui-autocomplete-row
    {
      padding:8px;
      background-color: #f4f4f4;
      border-bottom:1px solid #ccc;
      font-weight:bold;
    }
    .ui-autocomplete-row:hover
    {
      background-color: #ddd;
    }
    .zoom {
    transition: transform .2s; 
    }
 
    .zoom:hover {
    transform: scale(1.8); 
    }
</style>

    <div class="fuente" style="">
      <h3 align="">Buscar producto</h3>
      <div class="row">
        <form id="insert_row" >
          <div class="input-field col s4">
            <div class="col s6">
              <input type="text" id="search_data" placeholder="Buscar producto" autocomplete="off" class="validate" required />
            </div>

            <div class="col s3">
              <input type="number" id="cantidad_" placeholder="Cantidad" autocomplete="off" required>
            </div>

            <div class="col s3">
              <input type="text" onkeypress="return check(event)" id="pupesos_" placeholder="Precio en Pesos Arg." min="1" required>
            </div>

            
            <input type="text" id="id_" value="" hidden>
            <input type="text" id="linea_" value="" hidden>
            <input type="text" id="codli_" value="" hidden>
            <!-- <input type="text" id="pubs_" value="" hidden> -->
          </div>

          <div class="col s2">
            <button class="btn waves-effect waves-light btn-large" type="submit" ><i class="material-icons right">assignment</i>Insertar</button>
          </div>
        </form>
        

        <div class="input-field col s1">
           % Descuento: 
          <div class="input-field inline">
            <input id="descuento_" type="number" min="0" max="100" value="0" class="validate">
          </div>
            

            

          <!-- </div> -->
        </div>

      </div>
    </div>

<div class="row">
  <div class="col s10">
  <table id="tabla_compras" class="highlight">
    <thead>
      <tr>
          <!-- <th>Ver</th> -->
          <th>Código<br>(Producto)</th>
          <th>Linea</th>
          <th>Descripción</th>
          <th>Cantidad</th>
          <th>P.U.<br>(pesos arg.)</th>
          <th>P.U. con <br>descuento (Pesos)</th>
          <th>P.U.<br>(Bs.)</th>
          <th>P.U. con <br>descuento (Bs.)</th>
          <th>Valor de compra <br>S.D. (Bs.)</th>
          <th>Valor de compra <br>C.D. (Bs.)</th>
          <th>Borrar</th>
          <th hidden>AUX</th>
      </tr>
    </thead>

    <tbody id="tabla_c" class="tabla_c">
    </tbody>
  </table>
  </div>

<div class="col s2 ">
    <a class="waves-effect waves-light btn-large " id="modal" href="#modal1"><i class="material-icons right">receipt</i>Registrar compra</a>
  </div>
</div>

<!--MODAL AGREGAR PRODUCTO-->
<div class="row">
<div id="modal1" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h5 class="fuente"><b>Se registrará la compra y se imprimirá un recibo.</b></h5> <br><br> 
  </div>
  <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-light btn-flat red left">CANCELAR</a>
      <a id="btn-create_html" href="#!" onclick="crear_html()" class="waves-effect waves-light btn">REGISTRAR COMPRA</a>
  </div>
</div>
</div>


<script>

//recuperar por formdata y enviar por json al lado servidor mediante ajax
//Crear un array con indices y guardar luego los datos de cantidad y pesos ahi... mediante el indice

$(document).ready(function(){
    $('#modal').leanModal();
    $('#search_data').autocomplete({
      source: "recursos/compras/buscar_prod.php",
      minLength: 1,
      select: function(event, ui)
      {
        $("#id_").val(ui.item.id)
        $("#linea_").val(ui.item.linea)
        $("#pupesos_").val(parseFloat(ui.item.pupesos).toFixed(1))
        $("#codli_").val(ui.item.codli)
        $('#search_data').val(ui.item.value)
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        // console.log(item)
        return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };
});

document.getElementById("insert_row").addEventListener("submit", function (event) {
  event.preventDefault();



  $("#descuento_").prop('disabled', true);
  let codli = $("#codli_").val()
//Convertir precio en pesos a precio en Bs.
  let pupesos = parseFloat($("#pupesos_").val())
  let pubs_ = parseFloat($("#pupesos_").val()) * parseFloat($("#valor").val())
  let desc_ = parseFloat($("#descuento_").val())
  let _aux_cant = 0
  if (codli == '16' || codli == '33' || codli == '34' || codli == '35' || codli == '36' || codli == '37') {
      _aux_cant = parseInt($("#cantidad_").val())
      pupesos_desc = pupesos
      pubs_desc = pubs_
  }else{
  // PRECIO CON DESCUENTO EN PESOS
    desc_ = desc_ * 0.01
    pupesos_desc = pupesos * desc_
    pupesos_desc = pupesos - pupesos_desc
    pupesos_desc = pupesos_desc.toFixed(2)
  // PRECIO CON DESCUENTO EN BS.
    pubs_desc = pubs_
    pubs_desc = parseFloat(pubs_desc) * desc_
    pubs_desc = pubs_ - pubs_desc
 
  }
  //Subtotal sin descuento
  precio_sd = parseFloat($("#cantidad_").val()) * pubs_
  precio_sd = precio_sd.toFixed(1)+"0"
  //Subtotal con descuento
  precio_cd = parseFloat($("#cantidad_").val()) * pubs_desc
  precio_cd = precio_cd.toFixed(1)+"0"
  //haciendo el redondeo al final 
  __pubs = pubs_
  pubs_desc = pubs_desc.toFixed(2)
  pupesos = pupesos.toFixed(2)
  pubs_ = pubs_.toFixed(2)


  let table = document.getElementById("tabla_c")
  let newTableRow = table.insertRow(-1)
  let newRow = newTableRow.insertCell(0)


  newRow.textContent = $("#id_").val()
  newRow.className = "_id"

  newRow = newTableRow.insertCell(1)
  newRow.textContent = $("#linea_").val()
  newRow.className = "_linea"

  newRow = newTableRow.insertCell(2)
  newRow.textContent = $("#search_data").val()
  newRow.className = "_descripcion"

  newRow = newTableRow.insertCell(3)
  newRow.textContent = $("#cantidad_").val()
  newRow.className = "_cantidad"

  newRow = newTableRow.insertCell(4)
  newRow.textContent = pupesos
  newRow.className = "_pupesos"

  newRow = newTableRow.insertCell(5)
  newRow.textContent = pupesos_desc
  newRow.className = "_pupesos_desc"

  newRow = newTableRow.insertCell(6)
  newRow.textContent = pubs_
  newRow.className = "_pubs"

  newRow = newTableRow.insertCell(7)
  newRow.textContent = pubs_desc
  newRow.className = "_pubs_desc"

  newRow = newTableRow.insertCell(8)
  newRow.textContent = precio_sd
  newRow.className = "_precio_sd"

  newRow = newTableRow.insertCell(9)
  newRow.textContent = precio_cd
  newRow.className = "_precio_cd"

  newRow = newTableRow.insertCell(10)
  newRow.innerHTML = '<a href="#!" onclick="delete_row(event)" class="btn-floating red"><i class="material-icons">delete</i></a>'

  newRow = newTableRow.insertCell(11)
  newRow.style.visibility = 'hidden'
  newRow.innerHTML = ' <input type="text" value="'+_aux_cant+'" class="_aux" hidden>'

  newRow = newTableRow.insertCell(12)
  newRow.style.visibility = 'hidden'
  newRow.innerHTML = ' <input type="text" value="'+__pubs+'" class="__pubs" hidden>'



  $("#search_data").val("")
  $("#cantidad_").val("")
  $("#pupesos_").val("")
});



function detalle_compra() {

  let array_ = [];
document.querySelectorAll('#tabla_compras tbody tr').forEach(function(e){
  let fila = {
    id: e.querySelector('._id').innerText,
    linea: e.querySelector('._linea').innerText,
    descripcion: e.querySelector('._descripcion').innerText,
    cantidad: e.querySelector('._cantidad').innerText,
    pupesos: e.querySelector('._pupesos').innerText,
    pubs: e.querySelector('._pubs').innerText,
    pupesos_desc: e.querySelector('._pupesos_desc').innerText,
    pubs_desc: e.querySelector('._pubs_desc').innerText,
    precio_sd: e.querySelector('._precio_sd').innerText,
    precio_cd: e.querySelector('._precio_cd').innerText
  };
  array_.push(fila)
});
return (array_)
}

function crear_html() {

  document.getElementById('btn-create_html').removeAttribute("onclick");
  $("#btn-create_html").addClass('disabled')

  let filas = $("#tabla_compras").find('tbody tr').length;
  if(filas < 1) {
    Materialize.toast("Debe ingresar al menos un registro.", 5000);
    habilitar_boton()
    return false;
  }

var date = new Date();
var options = { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric' };
date = date.toLocaleDateString("es-ES", options)

array_ = "";
let items = 0
var pubs__ = 0
var pubs__desc = 0
let gan_exp = 0 
var totalsd = 0
var totalcd = 0
var descuento = 0

document.querySelectorAll('#tabla_compras tbody tr').forEach(function(e){
  
  let fila = `<tr>
                <td>${e.querySelector('._id').innerText}</td>
                <td>${e.querySelector('._linea').innerText}</td>
                <td>${e.querySelector('._descripcion').innerText}</td>
                <td>${e.querySelector('._cantidad').innerText}</td>
                <td>${e.querySelector('._pupesos').innerText}</td>
                <td>${e.querySelector('._pubs').innerText}</td>
                <td>${e.querySelector('._pupesos_desc').innerText}</td>
                <td>${e.querySelector('._pubs_desc').innerText}</td>
                <td>${e.querySelector('._precio_cd').innerText}</td>
              </tr>`;
  
  array_ = array_ + fila;
  gan_exp = parseFloat(parseFloat(gan_exp) + (parseFloat(e.querySelector('.__pubs').value) * parseInt(e.querySelector('._cantidad').innerText))).toFixed(1)

  totalsd = totalsd + parseFloat(e.querySelector('._precio_sd').innerText);
  totalcd = totalcd + parseFloat(e.querySelector('._precio_cd').innerText);
  pubs__ = pubs__ + parseFloat(e.querySelector('._pubs').innerText);
  pubs__desc = pubs__desc + parseFloat(e.querySelector('._pubs_desc').innerText);
  items = items + parseInt(e.querySelector('._cantidad').innerText);
});

//sumando cantidad de productos auxiliares
let aux_sum = 0
$('._aux').each(function(){
    aux_sum = aux_sum + parseInt(this.value)
})

console.log(gan_exp+"---"+totalcd)
gan_exp = parseFloat(gan_exp).toFixed(1)
gan_exp = gan_exp - totalcd



_descuento = $("#descuento_").val();
_valor = $("#valor").val();



var data = detalle_compra()
data.push({_totalcd: totalcd})
data.push({_totalsd: totalsd})
data.push({_descuento: _descuento})
data.push({_valor: _valor})



var json_data = JSON.stringify(data)

// icd(json_data).then(res =>{
//   console.log(res)
// })

let year = (new Date).getFullYear()
let periodo = '<?php echo $_SESSION["periodox"]; ?>'
let per = periodo+" - "+year
insertar_compra_detalle(json_data).then(respuesta => {
  console.log(respuesta+" respuesta de funcion promise")

var miHtml = `<title>RECIBO DE COMPRA</title>

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
          <span><b>Laboratorio TRESA S.A.</b></span><br>
          <span>Código Arbell: 68929</span><br>
          <span>Lider/Experta: Mendez Plata</span>
        </td>
        <td width="33%" align="center">
          <span>Punto de venta: Principal</span><br>
          <span>Forma de pago: Efectivo</span><br>
          <span>Periodo: ${per}</span>
        </td>
        <td width="33%" align="right">
          <span>Distribuidora: CARMIÑA</span>
        </td>
      </tr>

    </table>

   
  <br>
  
   <h5>Items del comprobante</h5>
   <table width="100%" class="detalle">
    <thead>
      <tr >
        <th >Código<br>(producto)</th>
        <th >Linea</th>
        <th >Descripción</th>
        <th >Cantidad</th>
        <th >P.U. Pesos</th>
        <th >P.U. Bs.</th>
        <th >Precio con <br>descuento (pesos)</th>
        <th >Precio con <br>descuento (Bs.)</th>
        <th >Subtotal (Bs.)</th>
      </tr>
    </thead>
    <tbody>
      ${array_}
    </tbody>
   </table>
   <br>
   <br>

  <div style="float: right">
   <h5>Totales:</h5>
  
     <table class="detalle">
      <tr>
        <td><b>Items:</b></td>
        <td><b>${items} u. Incluye ${aux_sum} aux.:</b></td>
      </tr>
      <tr>
        <td><b>Ganancias experta:</b></td>
        <td>${gan_exp}</td>
      </tr>
      <tr>
        <td><b>Total a pagar:</b></td>
        <td>${totalcd}</td>
      </tr>
     </table>
   </div>
  </div>`;

imprimir(miHtml, respuesta);
$("#modal1").closeModal();
$("#tabla_c tr").remove(); 
habilitar_boton()
$("#descuento_").prop('disabled', false)
$("#descuento_").val('0')

})
}

function habilitar_boton() {
    document.getElementById("btn-create_html").setAttribute('onclick', "crear_html()");
    $("#btn-create_html").removeClass('disabled')
}

function imprimir(mihtml, numfac) {
    const $elementoParaConvertir = mihtml; // <-- Aquí puedes elegir cualquier elemento del DOM

    var ventana = window.open();
    ventana.document.write(mihtml);
    $(ventana.document).ready(function() {
        ventana.print();
        ventana.close();

        html2pdf()
        .set({
            margin: 1,
            filename: 'recibo_compra_'+numfac+'.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 3, // A mayor escala, mejores gráficos, pero más peso
                letterRendering: true,
            },
            jsPDF: {
                unit: "cm",
                format: "letter",
                orientation: 'portrait' // landscape o portrait
            }
        })
        .from($elementoParaConvertir)
        // .save()
        .catch(err => console.log(err));
    })
}

function insertar_compra_detalle (json_data) {
  
  return new Promise((resolve, rechazar) => {
    $.ajax({
      url: "recursos/compras/registrar_compra.php",
      data: {
        "json": json_data
      },
      method: "post",
      success: function(response) {
        resolve(response)
      },
      error: function(error) {
        console.log(error)
        rachazar(error)
      }
    });
})
}

// async function icd ( json_data) {
//   // Opciones por defecto estan marcadas con un *
//   const response = await fetch("recursos/compras/registrar_compra.php", {
//     method: 'POST', // *GET, POST, PUT, DELETE, etc.
//     body: {"jsonx": json_data} // body data type must match "Content-Type" header
//   });
//   console.log(response+"promesa fetch")
//   return response; // parses JSON response into native JavaScript objects
// }

//borrar elemento de un tabla
function delete_row(e) {
  console.log(e.target.parentNode.parentNode.parentNode.remove())
  let rows = document.getElementById('tabla_compras').getElementsByTagName('tr')
  if (rows.length <= 1) {
    $("#descuento_").prop('disabled', false);
  }
}



</script>
<script src="js/html2pdf.bundle.min.js"></script>


<!-- RECORDATORIO
  USAR EL CAMBIO DE PESOS A BOLIVIANOS EN EL REGISTRO DE COMPRAS
  
  
 -->