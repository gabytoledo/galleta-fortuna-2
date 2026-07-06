<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireLogin();

require_once __DIR__ . "/../app/repositories/UsuarioRepository.php";
require_once __DIR__ . "/../app/repositories/HistorialRepository.php";
require_once __DIR__ . "/../app/repositories/FavoritoRepository.php";
require_once __DIR__ . "/../app/repositories/EstadisticaRepository.php";
require_once __DIR__ . "/../app/services/AchievementService.php";
require_once __DIR__ . "/../app/services/StreakService.php";

$usuarioId = (int)$_SESSION["usuario_id"];

$usuarioRepository = new UsuarioRepository();
$historialRepository = new HistorialRepository();
$favoritoRepository = new FavoritoRepository();
$estadisticaRepository = new EstadisticaRepository();

$usuario = $usuarioRepository->obtenerPorId($usuarioId);
$totalAperturas = $historialRepository->obtenerCantidadAperturas($usuarioId);
$totalFavoritas = $favoritoRepository->contarPorUsuario($usuarioId);

$diasConAperturas = $historialRepository->obtenerDiasConAperturas($usuarioId);
$rachaActual = StreakService::calcularRacha($diasConAperturas);

$logros = AchievementService::obtenerLogros($totalAperturas);
$logrosDesbloqueados = count(array_filter($logros, fn($logro) => $logro["desbloqueado"]));

$ranking = $estadisticaRepository->obtenerRankingCompleto();
$posicionRanking = "-";

foreach ($ranking as $index => $item) {
    if ((int)$item["id"] === $usuarioId) {
        $posicionRanking = "#" . ($index + 1);
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Mi perfil</title>
</head>
<button type="button" id="darkToggle" class="dark-toggle">
    🌙
</button>
<body class="historial-page">

<div class="container">

    <h1>👤 Mi perfil</h1>

    <?php if ($usuario === null): ?>

        <p>No se pudo cargar el perfil.</p>

    <?php else: ?>

        <div class="last-activity-card">
            <h2><?php echo htmlspecialchars($usuario["nombre"]); ?></h2>

            <p>
                <strong>Email:</strong>
                <?php echo htmlspecialchars($usuario["email"]); ?>
            </p>

            <p>
                <strong>Rol:</strong>
                <?php echo htmlspecialchars($usuario["rol"]); ?>
            </p>
        </div>

        <div class="stats-grid">

            <div class="stat-card">
                <h2>🥠 Aperturas</h2>
                <p><?php echo (int)$totalAperturas; ?></p>
            </div>

            <div class="stat-card">
                <h2>❤️ Favoritas</h2>
                <p><?php echo (int)$totalFavoritas; ?></p>
            </div>

            <div class="stat-card">
                <h2>🔥 Racha</h2>
                <p><?php echo (int)$rachaActual; ?></p>
            </div>

            <div class="stat-card">
                <h2>🏆 Ranking</h2>
                <p><?php echo htmlspecialchars($posicionRanking); ?></p>
            </div>

            <div class="stat-card">
                <h2>🏅 Logros</h2>
                <p><?php echo (int)$logrosDesbloqueados; ?>/<?php echo count($logros); ?></p>
            </div>

        </div>

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