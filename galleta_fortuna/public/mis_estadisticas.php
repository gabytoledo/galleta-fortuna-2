<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
require_once __DIR__ . "/../app/repositories/HistorialRepository.php";
require_once __DIR__ . "/../app/services/AchievementService.php";
require_once __DIR__ . "/../app/services/StreakService.php";

SessionManager::requireLogin();

$usuarioId = (int) $_SESSION["usuario_id"];

$historialRepository = new HistorialRepository();

$totalAperturas = $historialRepository->obtenerCantidadAperturas($usuarioId);
$ultimaGalleta = $historialRepository->obtenerUltimaGalleta($usuarioId);
$topMensajes = $historialRepository->obtenerTopMensajesUsuario($usuarioId);

$diasConAperturas = $historialRepository->obtenerDiasConAperturas($usuarioId);
$rachaActual = StreakService::calcularRacha($diasConAperturas);

$logros = AchievementService::obtenerLogros($totalAperturas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="UTF-8">
    <title>Mis estadísticas</title>
</head>

<body class="historial-page">

<div class="container">

    <h1>Mis estadísticas</h1>

    <div class="stats-grid">

        <div class="stat-card">
            <h2>🥠 Galletas abiertas</h2>
            <p><?php echo (int)$totalAperturas; ?></p>
        </div>

        <div class="stat-card">
            <h2>🔥 Racha actual</h2>
            <p><?php echo (int)$rachaActual; ?></p>
            <small>días seguidos</small>
        </div>

    </div>

    <?php if ($ultimaGalleta !== null): ?>
        <div class="last-activity-card">
            <h2>🕓 Última fortuna</h2>

            <p class="last-message">
                "<?php echo htmlspecialchars($ultimaGalleta["mensaje"]); ?>"
            </p>

            <p>
                <?php
                $fecha = new DateTime($ultimaGalleta["fecha_apertura"]);
                echo htmlspecialchars($fecha->format("d/m/Y H:i:s"));
                ?>
            </p>
        </div>
    <?php endif; ?>

    <hr>

    <h2>Mis logros</h2>

    <div class="achievement-grid">
        <?php foreach ($logros as $logro): ?>
            <div class="achievement-card <?php echo $logro["desbloqueado"] ? "unlocked" : "locked"; ?>">

                <div class="achievement-icon">
                    <?php echo $logro["icono"]; ?>
                </div>

                <h3>
                    <?php echo htmlspecialchars($logro["nombre"]); ?>
                </h3>

                <p>
                    <?php echo htmlspecialchars($logro["descripcion"]); ?>
                </p>

                <small>
                    <?php echo $logro["desbloqueado"] ? "Desbloqueado" : "Bloqueado"; ?>
                </small>

            </div>
        <?php endforeach; ?>
    </div>

    <hr>

    <h2>Mis mensajes más frecuentes</h2>

    <?php if (empty($topMensajes)): ?>
        <p>Todavía no hay datos suficientes.</p>
    <?php else: ?>
        <canvas id="chartMisMensajes"></canvas>
    <?php endif; ?>

    <br>

    <a href="home.php">Volver al inicio</a>

</div>

<?php if (!empty($topMensajes)): ?>
<script>
const labels = <?php echo json_encode(
    array_map(
        fn($m) => mb_substr($m["texto"], 0, 45) . "...",
        $topMensajes
    ),
    JSON_UNESCAPED_UNICODE
); ?>;

const data = <?php echo json_encode(
    array_map(
        fn($m) => (int)$m["total"],
        $topMensajes
    )
); ?>;

new Chart(document.getElementById("chartMisMensajes"), {
    type: "bar",
    data: {
        labels: labels,
        datasets: [{
            label: "Veces obtenido",
            data: data
        }]
    },
    options: {
        indexAxis: "y",
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>
<?php endif; ?>

</body>
</html>