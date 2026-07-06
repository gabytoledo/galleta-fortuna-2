<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireLogin();

require_once __DIR__ . "/../app/repositories/EstadisticaRepository.php";

$estadisticaRepository = new EstadisticaRepository();
$ranking = $estadisticaRepository->obtenerTopUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Ranking</title>
</head>
<body class="historial-page">
<button type="button" id="darkToggle" class="dark-toggle">
    🌙
</button>
<div class="container">

    <h1>🏆 Ranking de usuarios</h1>

    <?php if (empty($ranking)): ?>
        <p>Todavía no hay datos suficientes.</p>
    <?php else: ?>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Puesto</th>
                    <th>Usuario</th>
                    <th>Aperturas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ranking as $index => $usuario): ?>
                    <tr>
                        <td>
                            <?php
                            $puesto = $index + 1;

                            if ($puesto === 1) {
                                echo "🥇 1";
                            } elseif ($puesto === 2) {
                                echo "🥈 2";
                            } elseif ($puesto === 3) {
                                echo "🥉 3";
                            } else {
                                echo (int)$puesto;
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($usuario["nombre"]); ?></td>
                        <td><?php echo (int)$usuario["total"]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

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