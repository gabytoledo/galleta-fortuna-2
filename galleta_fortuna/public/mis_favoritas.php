<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireLogin();

require_once __DIR__ . "/../app/repositories/FavoritoRepository.php";

$favoritoRepository = new FavoritoRepository();

$favoritas = $favoritoRepository->obtenerPorUsuario(
    (int)$_SESSION["usuario_id"]
);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Mis favoritas</title>
</head>

<body class="historial-page">
<button type="button" id="darkToggle" class="dark-toggle">
    🌙
</button>
<div class="container">

    <h1>Mis fortunas favoritas</h1>

    <?php if (empty($favoritas)): ?>
        <p>Todavía no guardaste ninguna fortuna favorita.</p>
    <?php else: ?>

        <?php foreach ($favoritas as $favorita): ?>
            <div class="last-activity-card">
                <p class="last-message">
                    "<?php echo htmlspecialchars($favorita["mensaje_texto"]); ?>"
                </p>

                <small>
                    Guardada el:
                    <?php
                    $fecha = new DateTime($favorita["fecha_guardado"]);
                    echo htmlspecialchars($fecha->format("d/m/Y H:i:s"));
                    ?>
                </small>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>

    <br>

    <a href="home.php">Volver al inicio</a>

</div>
<script>
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