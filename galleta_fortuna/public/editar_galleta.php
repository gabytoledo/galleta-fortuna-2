<?php

require_once __DIR__ . "/../app/core/SessionManager.php";
SessionManager::requireAdmin();

require_once __DIR__ . "/../app/services/FortuneService.php";

$id = intval($_GET["id"] ?? 0);

$fortuneService = new FortuneService();
$galleta = $fortuneService->obtenerGalletaPorId($id);

if ($galleta === null) {
    $_SESSION["admin_error"] = "La galleta solicitada no existe.";
    header("Location: admin_panel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <meta charset="UTF-8">
    <title>Editar Galleta</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <h1>Editar Galleta</h1>

    <form action="actualizar_galleta.php" method="POST">

        <input
            type="hidden"
            name="id"
            value="<?php echo (int) $galleta["id"]; ?>"
        >

        <textarea
            name="texto"
            rows="6"
            style="width:100%;padding:10px;"
            required
        ><?php echo htmlspecialchars($galleta["texto"]); ?></textarea>

        <br><br>

        <button type="submit">
            GUARDAR CAMBIOS
        </button>

    </form>

    <br>

    <a href="admin_panel.php">Volver al panel</a>

</div>

</body>
</html>