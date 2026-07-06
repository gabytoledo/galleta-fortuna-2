<?php
require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

/*
 * Limpiamos la última fortuna para que
 * fortune.php arranque con la galleta cerrada.
 */
unset($_SESSION["mensaje_fortuna"]);
unset($_SESSION["fecha_fortuna"]);
unset($_SESSION["clima_fortuna"]);
?>

<!DOCTYPE html>

<html lang="es">
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Inicio - Galleta de la Fortuna</title>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
</head>
<body>
<button type="button" id="darkToggle" class="dark-toggle">
    🌙
</button>
<div class="container">


<h1>Bienvenido, <?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?></h1>

<p>Presioná el botón para abrir tu galleta de la fortuna.</p>

<a href="index.php?page=fortune">
    <button type="button">
        ABRE TU GALLETA
    </button>
</a>



<br><br>

<a href="subir_galleta.php">
    <button type="button">
        SUBIR GALLETA
    </button>
</a>

<?php if ($_SESSION["usuario_rol"] === "admin"): ?>
    <br><br>

    <a href="admin_panel.php">
        <button type="button">
            PANEL DE ADMIN
        </button>
    </a>
<?php endif; ?>

<br><br>

<a href="ranking.php">
    Ver ranking de usuarios
</a>

<br><br>

<a href="historial_galletas.php">
    Ver historial de galletas
</a>
<br><br>
<a href="mis_estadisticas.php">
    Ver mis estadísticas
</a>
<br><br>

<a href="mi_perfil.php">
    Ver mi perfil
</a>

<br><br>


<a href="mis_favoritas.php">
    Ver mis favoritas
</a>


<br><br>
<a href="logout.php">
    Cerrar sesión
</a>
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
