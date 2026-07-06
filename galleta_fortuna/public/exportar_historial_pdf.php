<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireLogin();

require_once __DIR__ . "/../app/repositories/HistorialRepository.php";

$historialRepository = new HistorialRepository();

$historial = $historialRepository->obtenerPorUsuario(
    (int) $_SESSION["usuario_id"]
);

$nombreUsuario = $_SESSION["usuario_nombre"] ?? "Usuario";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial PDF</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        @media print {
            .no-print {
                display: none;
            }

            body {
                background: white;
            }

            .container {
                box-shadow: none;
                width: 100%;
            }
        }
    </style>
</head>
<body class="historial-page">

<div class="container">

    <h1>Galleta Fortuna Pro</h1>

    <h2>Historial de <?php echo htmlspecialchars($nombreUsuario); ?></h2>

    <p>
        Fecha de generación:
        <?php
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        echo date("d/m/Y H:i:s");
        ?>
    </p>

    <?php if (empty($historial)): ?>

        <p>No hay historial para exportar.</p>

    <?php else: ?>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Mensaje</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($historial as $item): ?>
                    <tr>
                        <td>
                            <?php
                            $fecha = new DateTime($item["fecha_apertura"]);
                            echo htmlspecialchars($fecha->format("d/m/Y H:i:s"));
                            ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($item["mensaje"]); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

    <br>

    <div class="no-print">
        <button onclick="window.print()">
            📄 Guardar como PDF
        </button>

        <br><br>

        <a href="historial.php">Volver al historial</a>
    </div>

</div>

</body>
</html>