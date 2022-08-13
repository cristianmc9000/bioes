<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="theme-color" content="#ee6e73">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <link rel="icon" type="image/x-icon" href="img/iconoarbell.ico">
    <link rel="manifest" href="manifest.json">

    <link rel="stylesheet" href="css/pedidos.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" /> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">


    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <title>Ingreso</title>
</head>

<body id="cuerpo" style="background-color: #ede7f6">
    <div id="section_1">
        <div class="container">
            <div class="row">
                <h2 class="rubik center" style="color: #632480">Distribuidora Carmina</h2>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="center img_querie">
                    <img width="" src="img/logo_bio_2.png" alt="">
                </div>
            </div>
        </div>

        <div class="container" style="margin-top: 5%">
            <!-- <h4 class="fuente center">Ingresa tu código de cliente Arbell</h4> -->

            <div class="row">
                <!-- 				<div class="col s4 m3 l2 offset-l3 xl2 offset-xl3">
					<div class="input-field">
						<i class="material-icons-outlined prefix">phone</i>
						<input class="tam" type="text" id="phoneCode" name="phoneCode" value="+591" disabled>
					</div>
				</div> -->
                <div class="col s10 offset-s1 m8 l4 xl4 offset-m2 offset-l4 offset-xl4">
                    <form id="acceso">
                        <div class="input-field">
                            <i class="material-icons prefix">account_circle</i>
                            <input inputmode="numeric" class=" tam validate" type="text" id="codigo" name="codigo" />
                            <label for="codigo" class="tam active" style="color: #616161">Código Arbell</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">lock</i>
                            <input inputmode="numeric" class=" tam validate" type="password" id="pass" name="pass" />
                            <label for="pass" class="tam active" style="color: #616161">Contraseña</label>
                        </div>
                    </form>
                </div>
            </div>


            <div class="row">
                <div class="center centrar">
                    <div id="recaptcha-container"></div>
                </div>
            </div>
            <div class="row">
                <div class="center">
                    <button class="btn btn-large waves-effect waves-light deep-purple lighten-1" form="acceso"><i
                            class="material-icons-outlined right">lock</i>Ingresar</button>
                </div>
            </div>
        </div>
    </div>

</body>
<input type="text" id="existe" value="false" hidden>

<!-- <script type="module" src="https://www.gstatic.com/firebasejs/9.0.1/firebase-auth.js"></script> -->
<script src="script.js"></script>
<script>
$("#acceso").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData(document.getElementById("acceso"));
    $.ajax({
        url: "recursos/catalogos/acceder.php",
        type: "POST",
        dataType: "HTML",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(echo) {
        console.log(echo)
        if (echo == '2') {
            return M.toast({
                html: 'Usuario inhabilitado.'
            })
        }
        if (echo != "1") {
            return M.toast({
                html: 'Datos incorrectos.'
            })
        }
        if (echo == '1') {
            return window.location.replace("pedidos.php");
        }
    });
});
</script>

</html>