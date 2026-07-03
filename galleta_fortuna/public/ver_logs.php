<?php
require_once __DIR__ . "/../app/core/SessionManager.php";

SessionManager::requireAdmin();
$contenidoLogs = $_SESSION["contenido_logs"] ?? "No hay logs para mostrar.";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Logs del sistema</title>
</head>
<body class="historial-page">

<div class="container">

    <h1>Logs de auditoría</h1>

    <pre style="text-align: left; white-space: pre-wrap;">
<?php echo htmlspecialchars($contenidoLogs); ?>
    </pre>

    <br>
<a href="index.php?page=admin">

    <br><br>

   <a href="index.php?page=home">

    <br><br>

    <a href="logout.php">Cerrar sesión</a>

</div>

</body>
</html>