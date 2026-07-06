<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireAdmin();

require_once __DIR__ . "/../app/services/EstadisticaService.php";

$estadisticaService = new EstadisticaService();
$dashboard = $estadisticaService->obtenerDashboard();

$resumen = $dashboard["resumen"];
$topMensajes = $dashboard["topMensajes"];
$topUsuarios = $dashboard["topUsuarios"];
$ultimaActividad = $dashboard["ultimaActividad"];

$mensajesLabels = array_map(function ($m) {
    return mb_strlen($m["texto"]) > 65
        ? mb_substr($m["texto"], 0, 65) . "..."
        : $m["texto"];
}, $topMensajes);

$mensajesData = array_map(fn($m) => (int)$m["total"], $topMensajes);
$usuariosLabels = array_map(fn($u) => $u["nombre"], $topUsuarios);
$usuariosData = array_map(fn($u) => (int)$u["total"], $topUsuarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="UTF-8">
    <title>Estadísticas</title>
</head>

<body class="historial-page">

<div class="container">

    <h1>Dashboard de estadísticas</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <h2>👥 Usuarios</h2>
            <p><?php echo (int)$resumen["usuarios"]; ?></p>
        </div>

        <div class="stat-card">
            <h2>📜 Mensajes</h2>
            <p><?php echo (int)$resumen["mensajes"]; ?></p>
        </div>

        <div class="stat-card">
            <h2>🥠 Aperturas</h2>
            <p><?php echo (int)$resumen["aperturas"]; ?></p>
        </div>
    </div>



    <?php if ($ultimaActividad !== null): ?>
    <div class="last-activity-card">
        <h2>🔥 Última actividad</h2>

        <p>
            <strong><?php echo htmlspecialchars($ultimaActividad["usuario"]); ?></strong>
            abrió una galleta.
        </p>

        <p class="last-message">
            "<?php echo htmlspecialchars($ultimaActividad["mensaje"]); ?>"
        </p>

        <p>
            <?php
            $fecha = new DateTime($ultimaActividad["fecha_apertura"]);
            echo htmlspecialchars($fecha->format("d/m/Y H:i:s"));
            ?>
        </p>
    </div>
<?php endif; ?>
    <hr>

    <h2>Gráficos generales</h2>

    <div class="charts-grid">

        <div class="chart-card chart-wide">
            <h3>Top 5 mensajes más mostrados</h3>
            <canvas id="chartMensajes"></canvas>
        </div>

        <div class="chart-card">
            <h3>Top 3 usuarios más activos</h3>
            <canvas id="chartUsuarios"></canvas>
        </div>

    </div>

    <hr>

    <h2>Top 5 mensajes más mostrados</h2>

    <?php if (empty($topMensajes)): ?>
        <p>No hay datos suficientes.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Mensaje</th>
                    <th>Veces mostrado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topMensajes as $mensaje): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mensaje["texto"]); ?></td>
                        <td><?php echo (int)$mensaje["total"]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <hr>

    <h2>Top 3 usuarios más activos</h2>

    <?php if (empty($topUsuarios)): ?>
        <p>No hay datos suficientes.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Aperturas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topUsuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario["nombre"]); ?></td>
                        <td><?php echo htmlspecialchars($usuario["email"]); ?></td>
                        <td><?php echo (int)$usuario["total"]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <br>

    <a href="admin_panel.php">Volver al panel</a>

</div>

<script>
const mensajesLabels = <?php echo json_encode($mensajesLabels, JSON_UNESCAPED_UNICODE); ?>;
const mensajesData = <?php echo json_encode($mensajesData); ?>;

const usuariosLabels = <?php echo json_encode($usuariosLabels, JSON_UNESCAPED_UNICODE); ?>;
const usuariosData = <?php echo json_encode($usuariosData); ?>;

new Chart(document.getElementById("chartMensajes"), {
    type: "bar",
    data: {
        labels: mensajesLabels,
        datasets: [{
            label: "Veces mostrado",
            data: mensajesData,
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: "y",
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return "Veces mostrado: " + context.raw;
                    }
                }
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            },
            y: {
                ticks: {
                    font: {
                        size: 13
                    }
                }
            }
        }
    }
});

new Chart(document.getElementById("chartUsuarios"), {
    type: "doughnut",
    data: {
        labels: usuariosLabels,
        datasets: [{
            label: "Aperturas",
            data: usuariosData,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: "bottom"
            }
        }
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