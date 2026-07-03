<?php
require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>

<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <meta charset="UTF-8">
    <title>Subir Galleta</title>


<link rel="stylesheet" href="css/style.css">


</head>
<body>

<div class="container">


<h1>Subir Galleta</h1>

<div id="horno" style="font-size:120px;">
    🍪
</div>

<p id="estadoHorno">
    Escribí una nueva fortuna para el sistema.
</p>

<?php if (isset($_GET["success"])): ?>
    <p style="color:green;">
        ¡Galleta subida correctamente!
    </p>
<?php endif; ?>

<?php if (isset($_GET["error"])): ?>
    <p style="color:red;">
        Error al subir la galleta.
    </p>
<?php endif; ?>

<form id="formGalleta" action="procesar_galleta.php" method="POST">

    <textarea
        name="texto"
        rows="5"
        style="width:100%; padding:10px;"
        placeholder="Escribí tu mensaje sabio..."
        required
    ></textarea>

    <br><br>

    <button id="btnSubir" type="submit">
        SUBIR GALLETA
    </button>

</form>

<br>
<a href="home.php">
    Volver al inicio
</a>

</div>

<script>

document.getElementById("formGalleta").addEventListener("submit", function() {

    const boton = document.getElementById("btnSubir");
    const horno = document.getElementById("horno");
    const estado = document.getElementById("estadoHorno");

    boton.disabled = true;

    estado.innerText =
        "Horneando nueva fortuna...";

    let frame = 0;

    const animacion = setInterval(function() {

        frame++;

        switch(frame % 4)
        {
            case 0:
                horno.innerText = "🍪";
                break;

            case 1:
                horno.innerText = "🔥";
                break;

            case 2:
                horno.innerText = "🥠";
                break;

            case 3:
                horno.innerText = "✨";
                break;
        }

    }, 180);

    setTimeout(function() {

        clearInterval(animacion);

        horno.innerText = "🥠";

    }, 3000);

});

</script>

</body>
</html>
