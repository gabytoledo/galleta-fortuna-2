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

</body>
</html>