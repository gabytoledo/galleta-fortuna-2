<?php
require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$mensaje = $_SESSION["mensaje_fortuna"] ?? "Todavía no abriste ninguna galleta.";
$fecha = $_SESSION["fecha_fortuna"] ?? "";
$clima = $_SESSION["clima_fortuna"] ?? "";
?>

<!DOCTYPE html>

<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Tu fortuna</title>
</head>
<body>

<div class="container">


<h1>Tu mensaje de la fortuna</h1>

<div id="galletaAnimada" class="cookie-animation">
    🥠
</div>

<p class="mensaje" id="mensajeFortuna">
    "<?php echo htmlspecialchars($mensaje); ?>"
</p>

<?php if (!empty($fecha) && $mensaje !== "🥠 Tu fortuna está esperando..." && $mensaje !== "Todavía no abriste ninguna galleta."): ?>

    <form id="formFavorito" action="guardar_favorito.php" method="POST" style="display:none;">
    <input
        type="hidden"
        name="mensaje"
        id="mensajeFavorito"
        value=""
    >

    <button type="submit">
        ❤️ Guardar favorita
    </button>
    <button
    type="button"
    id="btnCompartir"
    style="display:none;"
>
    📤 Compartir fortuna
</button>
</form>


<?php endif; ?>

<p id="fechaFortuna">
    <?php if (!empty($fecha)): ?>
        <strong>Fecha y hora de apertura:</strong><br>
        <?php echo htmlspecialchars($fecha); ?>
    <?php endif; ?>
</p>

<div class="weather-box" id="weatherBox" <?php echo empty($clima) ? 'style="display:none;"' : ''; ?>>
    <strong>Clima actual</strong>
    <p class="weather-info" id="climaFortuna">
        <?php echo htmlspecialchars($clima); ?>
    </p>
</div>

<form id="formGalleta">
    <button type="button" id="btnAbrirGalleta">
        ABRIR OTRA GALLETA
    </button>
</form>

<p id="loadingText" style="display:none;">
    Abriendo tu galleta...
</p>

<br>

<a href="home.php">
    Volver al inicio
</a>
<br><br>

<a href="logout.php">Cerrar sesión</a>


</div>

<script>
document.getElementById("btnAbrirGalleta").addEventListener("click", function () {

    const boton = document.getElementById("btnAbrirGalleta");
    const loading = document.getElementById("loadingText");
    const galleta = document.getElementById("galletaAnimada");
    const weatherBox = document.getElementById("weatherBox");

    boton.disabled = true;
    loading.style.display = "block";

    galleta.innerText = "🥠";
    galleta.style.fontSize = "200px";
    galleta.style.position = "relative";
    galleta.style.display = "block";
    galleta.style.textAlign = "center";

    let paso = 0;

    const animacion = setInterval(function () {
        paso++;

        if (paso % 2 === 0) {
            galleta.style.left = "-40px";
            galleta.style.top = "0px";
            galleta.style.fontSize = "220px";
            galleta.innerText = "🥠";
        } else {
            galleta.style.left = "40px";
            galleta.style.top = "-20px";
            galleta.style.fontSize = "250px";
            galleta.innerText = "💥";
        }

    }, 150);

    function enviarPeticion(latitud = "", longitud = "") {

        const formData = new FormData();
        formData.append("latitud", latitud);
        formData.append("longitud", longitud);

        fetch("ajax_abrir_galleta.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {

            setTimeout(function () {

                clearInterval(animacion);

                galleta.innerText = "📜";
                galleta.style.left = "0px";
                galleta.style.top = "0px";
                galleta.style.fontSize = "180px";

                if (data.success) {
                  const mensaje = document.getElementById("mensajeFortuna");

mensaje.style.transition = "opacity 0.5s ease";
mensaje.style.opacity = "0";
document.getElementById("mensajeFavorito").value = data.mensaje;
document.getElementById("formFavorito").style.display = "block";
document.getElementById("btnCompartir").style.display = "inline-block";
setTimeout(function () {


mensaje.innerText =
    '"' + data.mensaje + '"';

mensaje.style.opacity = "1";


}, 300);


                    document.getElementById("fechaFortuna").innerHTML =
                        "<strong>Fecha y hora de apertura:</strong><br>" + data.fecha;

                    document.getElementById("climaFortuna").innerText =
                        data.clima;

                    weatherBox.style.display = "block";
                } else {
                    alert(data.message);
                }

                boton.disabled = false;
                loading.style.display = "none";

            }, 1200);
        })
        .catch(function () {
            clearInterval(animacion);

            alert("Error al abrir la galleta.");

            galleta.innerText = "🥠";
            galleta.style.left = "0px";
            galleta.style.top = "0px";

            boton.disabled = false;
            loading.style.display = "none";
        });
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                enviarPeticion(position.coords.latitude, position.coords.longitude);
            },
            function () {
                enviarPeticion();
            }
        );
    } else {
        enviarPeticion();
    }

});

document.getElementById("btnCompartir").addEventListener("click", function(){

    const mensaje =
        document.getElementById("mensajeFortuna")
        .innerText
        .replace(/"/g,"");

    const texto =
`🥠 Mi fortuna de hoy

"${mensaje}"

Generado con Galleta Fortuna Pro`;

    navigator.clipboard.writeText(texto)
        .then(function(){

            alert("✅ ¡Fortuna copiada al portapapeles!");

        })
        .catch(function(){

            alert("No fue posible copiar la fortuna.");

        });

});
</script>


</body>
</html>
