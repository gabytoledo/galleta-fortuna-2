<?php
require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireLogin();

$mensaje = $_SESSION["mensaje_fortuna"] ?? "Todavía no abriste ninguna galleta.";
$fecha = $_SESSION["fecha_fortuna"] ?? "";
$clima = $_SESSION["clima_fortuna"] ?? "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Tu fortuna</title>
</head>
<body>

<button type="button" id="darkToggle" class="dark-toggle">
    🌙
</button>

<div class="container">

    <h1>Tu mensaje de la fortuna</h1>

    <div id="galletaAnimada" class="cookie-animation">
        🥠
    </div>

    <p class="mensaje" id="mensajeFortuna">
        "<?php echo htmlspecialchars($mensaje); ?>"
    </p>

<form
    id="formFavorito"
    action="guardar_favorito.php"
    method="POST"
    <?php echo empty($fecha) ? 'style="display:none;"' : ''; ?>
>

    <input
        type="hidden"
        name="mensaje"
        id="mensajeFavorito"
        value="<?php echo htmlspecialchars($mensaje); ?>"
    >

    <button type="submit">
        ❤️ Guardar favorita
    </button>

</form>

<br>

<button
    type="button"
    id="btnCompartir"
    <?php echo empty($fecha) ? 'style="display:none;"' : ''; ?>
>
    📤 Compartir fortuna
</button>

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

    <a href="home.php">Volver al inicio</a>

    <br><br>

    <a href="logout.php">Cerrar sesión</a>

</div>

<div id="toast" class="toast"></div>

<script>
function mostrarToast(mensaje)
{
    const toast = document.getElementById("toast");

    if (!toast) {
        return;
    }

    toast.innerText = mensaje;
    toast.classList.add("show");

    setTimeout(function(){
        toast.classList.remove("show");
    }, 3000);
}

function lanzarConfetti(cantidad = 120)
{
    if (typeof confetti === "function") {
        confetti({
            particleCount: cantidad,
            spread: 80,
            origin: { y: 0.6 }
        });
    }
}

const botonAbrir = document.getElementById("btnAbrirGalleta");

botonAbrir.addEventListener("click", function () {

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
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {

            setTimeout(function () {

                clearInterval(animacion);

                galleta.innerText = "📜";
                galleta.style.left = "0px";
                galleta.style.top = "0px";
                galleta.style.fontSize = "180px";

                if (data.success) {

                    const mensajeElemento = document.getElementById("mensajeFortuna");

                    mensajeElemento.style.transition = "opacity 0.5s ease";
                    mensajeElemento.style.opacity = "0";

                    setTimeout(function () {
                        mensajeElemento.innerText = '"' + data.mensaje + '"';
                        mensajeElemento.style.opacity = "1";
                    }, 300);

                    const mensajeFavorito = document.getElementById("mensajeFavorito");
                    const formFavorito = document.getElementById("formFavorito");
                    const btnCompartir = document.getElementById("btnCompartir");

                    if (mensajeFavorito && formFavorito) {
                        mensajeFavorito.value = data.mensaje;
                        formFavorito.style.display = "block";
                    }

                    if (btnCompartir) {
                        btnCompartir.style.display = "inline-block";
                    }

                    document.getElementById("fechaFortuna").innerHTML =
                        "<strong>Fecha y hora de apertura:</strong><br>" + data.fecha;

                    document.getElementById("climaFortuna").innerText =
                        data.clima;

                    weatherBox.style.display = "block";

                    lanzarConfetti(130);

                } else {
                    mostrarToast(data.message);
                }

                boton.disabled = false;
                loading.style.display = "none";

            }, 1200);
        })
        .catch(function () {

            clearInterval(animacion);

            mostrarToast("❌ Error al abrir la galleta");

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

const botonCompartir = document.getElementById("btnCompartir");

if (botonCompartir) {
    botonCompartir.addEventListener("click", function(){

        const mensaje = document
            .getElementById("mensajeFortuna")
            .innerText
            .replace(/"/g, "");

        const texto =
`🥠 Mi fortuna de hoy

"${mensaje}"

Generado con Galleta Fortuna Pro`;

        navigator.clipboard.writeText(texto)
            .then(function(){
                mostrarToast("✅ Fortuna copiada al portapapeles");
                lanzarConfetti(80);
            })
            .catch(function(){
                mostrarToast("❌ No fue posible copiar la fortuna");
            });
    });
}

const darkToggle = document.getElementById("darkToggle");

if (localStorage.getItem("modoOscuro") === "activo") {
    document.body.classList.add("dark-mode");
    darkToggle.innerText = "☀️";
}

darkToggle.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("modoOscuro", "activo");
        darkToggle.innerText = "☀️";
    } else {
        localStorage.setItem("modoOscuro", "inactivo");
        darkToggle.innerText = "🌙";
    }
});
</script>

<script src="js/toast.js"></script>

<?php if (isset($_SESSION["toast_success"])): ?>
<script>
mostrarToast(
    <?php echo json_encode($_SESSION["toast_success"]); ?>,
    "success"
);
</script>
<?php unset($_SESSION["toast_success"]); ?>
<?php endif; ?>

<?php if (isset($_SESSION["toast_error"])): ?>
<script>
mostrarToast(
    <?php echo json_encode($_SESSION["toast_error"]); ?>,
    "error"
);
</script>
<?php unset($_SESSION["toast_error"]); ?>
<?php endif; ?>

</body>
</html>