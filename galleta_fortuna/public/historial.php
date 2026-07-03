<?php
require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$historial = $_SESSION["historial_galletas"] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Historial de galletas</title>
</head>
<body class="historial-page">
<br>


 
<div class="container">

    <h1>Historial de galletas abiertas</h1>

    <?php if (empty($historial)): ?>

        <p>Todavía no abriste ninguna galleta.</p>

    <?php else: ?>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Fecha y hora</th>
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

    <a href="home.php">Volver al inicio</a>

    <br><br>

    <a href="fortune.php">Volver a la galleta</a>

    <br><br>

    <a href="logout.php">Cerrar sesión</a>

</div>

</body>
</html>