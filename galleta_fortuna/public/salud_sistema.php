<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireAdmin();

require_once __DIR__ . "/../app/config/Database.php";

$checks = [];

try {
    $database = new Database();
    $database->conectar();

    $checks[] = ["nombre" => "Base de datos MySQL", "estado" => true];
} catch (Exception $e) {
    $checks[] = ["nombre" => "Base de datos MySQL", "estado" => false];
}

$checks[] = [
    "nombre" => "Archivo de logs",
    "estado" => file_exists(__DIR__ . "/../logs/audit.log")
];

$checks[] = [
    "nombre" => "Front Controller",
    "estado" => file_exists(__DIR__ . "/index.php")
];

$checks[] = [
    "nombre" => "SessionManager",
    "estado" => file_exists(__DIR__ . "/../app/core/SessionManager.php")
];

$checks[] = [
    "nombre" => "Servicio de clima",
    "estado" => file_exists(__DIR__ . "/../app/services/WeatherService.php")
];

$checks[] = [
    "nombre" => "Favoritos",
    "estado" => file_exists(__DIR__ . "/../app/repositories/FavoritoRepository.php")
];

$checks[] = [
    "nombre" => "Estadísticas",
    "estado" => file_exists(__DIR__ . "/../app/repositories/EstadisticaRepository.php")
];

$checks[] = [
    "nombre" => "Validaciones",
    "estado" => file_exists(__DIR__ . "/../app/validators/AuthValidator.php")
];

$total = count($checks);
$activos = count(array_filter($checks, fn($check) => $check["estado"]));
$porcentaje = $total > 0 ? round(($activos / $total) * 100) : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css?v=3.0">
    <meta charset="UTF-8">
    <title>Salud del sistema</title>
</head>
<body class="historial-page">

<button type="button" id="darkToggle" class="dark-toggle">
    🌙
</button>

<div class="container">

    <h1>🖥 Salud del sistema</h1>

    <div class="stat-card" style="margin: 20px auto;">
        <h2>Estado general</h2>
        <p><?php echo (int)$porcentaje; ?>%</p>
        <small><?php echo (int)$activos; ?> de <?php echo (int)$total; ?> servicios activos</small>
    </div>

    <div style="background:#dfe6e9;border-radius:20px;overflow:hidden;margin:20px 0;">
        <div style="width:<?php echo (int)$porcentaje; ?>%;background:#00b894;color:white;padding:10px;font-weight:bold;">
            <?php echo (int)$porcentaje; ?>%
        </div>
    </div>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($checks as $check): ?>
                <tr>
                    <td><?php echo htmlspecialchars($check["nombre"]); ?></td>
                    <td>
                        <?php if ($check["estado"]): ?>
                            🟢 Operativo
                        <?php else: ?>
                            🔴 Con error
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>

    <a href="admin_panel.php">Volver al panel</a>

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

</body>
</html>