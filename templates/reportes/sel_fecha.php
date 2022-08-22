<?php 
  date_default_timezone_set("America/La_Paz");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registro de ventas</title>
<style>

  .fuente{
    font-family: 'Segoe UI light';
    color: red;
  }

  /*.fijo{
    border-style: solid;
    border-color: red;
  }*/
  .auto-imagen{
    padding:  1px;
    border: 4px solid transparent;
    background: linear-gradient(60deg, #afafaf 10%, #4e4e4e 100%);
    width: 80%;
    height:  250px;
  }
  .vert{
    /*vertical-align: center;*/
/*    position: relative;
    top: 100%;*/
    padding-top: 150px;
  }

  .ui-autocomplete-row {
    padding: 8px;
    background-color: #f4f4f4;
    border-bottom: 1px solid #ccc;
    font-weight: bold;
  }

  .ui-autocomplete-row:hover {
      background-color: #ddd;
  }
  </style>
</head>
<body>

<div class="container vert">
  <div class="row">
    <div class="col-sm-8 offset-sm-2">

      <!-- <div class="input-group mb-3"> -->
        <label for="tipo_reporte">Seleccione el tipo de reporte:</label>
        <div class="input-group mb-3 col-sm-12">
          <select class="form-select" name="tipo_reporte" id="tipo_reporte" aria-label="Default select example">
              <option value="r_ventas.php" selected><b>Reportes de ventas</b></option>
              <option value="r_compras.php"><b>Reporte de compras</b></option>
              <option value="r_le.php"><b>Reporte de clientes</b></option>
              <option value="r_lider.php"><b>Reporte de líderes</b></option>
          </select>
        </div>

        <div class="col-sm-12" id="div_search_le" hidden>
          <label for="search_le" ><b>Seleccione la líder</b></label>
          <div class="input-group mb-3">
            <input type="text" id="search_le" placeholder="Buscar líder" autocomplete="off" class="form-control" aria-describedby="basic-addon3"/>
            <input type="text" id="codigo_le" hidden>
          </div>
        </div>

<!--         <label for="gestion"><b>Seleccione la gestión</b></label>
        <div class="input-group mb-3 col-sm-12">
                  <select class="form-select" aria-label="Default select example" name="gestion" id="gestion">
                    <option value="2021"  <?php if(date("Y") == "2021"){echo "selected";} ?>><b>2021</b></option>
                    <option value="2022"  <?php if(date("Y") == "2022"){echo "selected";} ?>><b>2022</b></option>
                    <option value="2023"  <?php if(date("Y") == "2023"){echo "selected";} ?>><b>2023</b></option>
                    <option value="2024"  <?php if(date("Y") == "2024"){echo "selected";} ?>><b>2024</b></option>
                    <option value="2025"  <?php if(date("Y") == "2025"){echo "selected";} ?>><b>2025</b></option>
                  </select> 
        </div> -->

        <!-- <label for="mes"><b>Seleccione el mes</b></label> -->
        <!-- <div class="input-group mb-3 col-sm-12"> -->
                <!-- <select class="form-select" aria-label="Default select example" name="mes" id="mes"> -->
                  <!-- <option value="0" selected>Reporte anual</option> -->
                  <!-- <option value="1">Reporte personalizado</option> -->
<!--                   <option value="01"><b>Enero</b></option>
                  <option value="02"><b>Febrero</b></option>
                  <option value="03"><b>Marzo</b></option>
                  <option value="04"><b>Abril</b></option>
                  <option value="05"><b>Mayo</b></option>
                  <option value="06"><b>Junio</b></option>
                  <option value="07"><b>Julio</b></option>
                  <option value="08"><b>Agosto</b></option>
                  <option value="09"><b>Septiembre</b></option>
                  <option value="10"><b>Octubre</b></option>
                  <option value="11"><b>Noviembre</b></option>
                  <option value="12"><b>Diciembre</b></option> -->
                <!-- </select> -->
        <!-- </div> -->


        <div id="div_fechas" class="row">
          <div class="col-sm-6" >
            <label for="search_le" ><b>Seleccione la fecha de inicio:</b></label>
            <div class="input-group mb-3">
              <input type="date" id="primera_fecha" placeholder="" autocomplete="off" class="form-control" aria-describedby="basic-addon3"/>
              <!-- <input type="date" id="segunda_fecha" placeholder="" autocomplete="off" class="form-control" aria-describedby="basic-addon3"/> -->
              <!-- <input type="text" id="codigo_le" hidden> -->
            </div>
          </div>
          <div class="col-sm-6" >
            <label for="search_le" ><b>Seleccione la fecha final:</b></label>
            <div class="input-group mb-3">
              <!-- <input type="date" id="primera_fecha" placeholder="" autocomplete="off" class="form-control" aria-describedby="basic-addon3"/> -->
              <input type="date" id="segunda_fecha" placeholder="" autocomplete="off" class="form-control" aria-describedby="basic-addon3"/>
              <!-- <input type="text" id="codigo_le" hidden> -->
            </div>
          </div>
        </div>

        <div class="input-group mb-3 col-sm-12">
          <!-- <a href="#" onclick="reporte_mes()" class="btn-large blue">Reporte por mes</a> -->
          <a href="#" onclick="reporte_ges()" class="btn btn-primary">Generar reporte</a>
        </div>
      <!-- </div> -->
    </div>
  </div>
</div>


<script>

  $(document).ready(function() {

  });

  $('#search_le').autocomplete({
      source: "recursos/reportes/buscar_lider.php",
      minLength: 3,
      select: function(event, ui) {
          $("#codigo_le").val(ui.item.ca)
          $('#search_le').val(ui.item.value)
      }
  }).data('ui-autocomplete')._renderItem = function(ul, item) {
      return $("<li class='ui-autocomplete-row'></li>")
          .data("item.autocomplete", item)
          .append(item.label)
          .appendTo(ul);
  };
  document.getElementById("tipo_reporte").addEventListener('change', () => {
    var option = document.getElementById("tipo_reporte").value;
    if (option == "r_lider.php") {
      document.getElementById("div_search_le").hidden = false;
      document.getElementById("search_le").disabled = false;
      document.getElementById("search_le").value = '';
      document.getElementById("codigo_le").value = '';
      // document.getElementById("search_le").setAttribute = 'required'
    }else{
      document.getElementById("search_le").value = '';
      document.getElementById("codigo_le").value = '';
      document.getElementById("search_le").disabled = true;
      document.getElementById("div_search_le").hidden = true;
      // document.getElementById("search_le").removeAttribute = 'required'
    }
  })




//reporte anual
function reporte_ges(){
  let fecha1 = document.getElementById('primera_fecha').value
  let fecha2 = document.getElementById('segunda_fecha').value

  let date1 = new Date(fecha1)
  let date2 = new Date(fecha2)  

  if (!fecha1 || !fecha2) {
    return mtoast('Debe ingresar una fecha de inicio y fin.', 'warning');
  }
  if (date2.getTime() <= date1.getTime()) {
    return mtoast('La fecha final debe ser mayor a la fecha inicio.', 'warning');
  }

  if (document.getElementById('tipo_reporte').value == 'r_lider.php' && document.getElementById('codigo_le').value == '') {
    return mtoast('Ingrese el nombre o código de una lider/experta', 'warning');
  }

  let tipo = document.getElementById('tipo_reporte').value
  let ca = document.getElementById('codigo_le').value

  $("#cuerpo").load("templates/reportes/"+tipo+"?fecha1="+fecha1+"&fecha2="+fecha2+"&ca="+ca)
}

</script>
</body>
</html>