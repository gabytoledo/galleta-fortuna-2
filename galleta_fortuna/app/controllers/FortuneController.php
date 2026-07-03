<?php

require_once __DIR__ . "/../core/SessionManager.php";
require_once __DIR__ . "/../services/FortuneService.php";

SessionManager::start();

class FortuneController
{
    private FortuneService $fortuneService;

    public function __construct()
    {
        $this->fortuneService = new FortuneService();
    }

    public function mostrarMensaje(): void
    {
        SessionManager::requireLogin();

        $latitud = $_POST["latitud"] ?? null;
        $longitud = $_POST["longitud"] ?? null;

        $resultado = $this->fortuneService->abrirGalleta(
            (int) $_SESSION["usuario_id"],
            $latitud,
            $longitud
        );

        if ($resultado === null) {
            $_SESSION["mensaje_fortuna"] = "No hay mensajes disponibles.";
            $_SESSION["fecha_fortuna"] = "";
            $_SESSION["clima_fortuna"] = "";
        } else {
            $_SESSION["mensaje_fortuna"] = $resultado["mensaje"];
            $_SESSION["fecha_fortuna"] = $resultado["fecha"];
            $_SESSION["clima_fortuna"] = $resultado["clima"];
        }

        header("Location: fortune.php");
        exit;
    }

    public function subirGalleta(): void
    {
        SessionManager::requireLogin();

        $texto = trim($_POST["texto"] ?? "");

        if ($texto === "") {
            header("Location: subir_galleta.php?error=vacio");
            exit;
        }

        $resultado = $this->fortuneService->subirMensaje($texto);

        if ($resultado) {
            header("Location: subir_galleta.php?success=1");
            exit;
        }

        header("Location: subir_galleta.php?error=1");
        exit;
    }

    public function eliminarGalleta(): void
    {
        SessionManager::requireAdmin();

        $id = intval($_POST["id"] ?? 0);

        if ($id <= 0) {
            $_SESSION["admin_error"] = "ID inválido.";
            header("Location: admin_panel.php");
            exit;
        }

        $resultado = $this->fortuneService->eliminarGalleta($id);

        if ($resultado) {
            $_SESSION["admin_success"] = "Galleta eliminada correctamente.";
        } else {
            $_SESSION["admin_error"] = "No se pudo eliminar la galleta.";
        }

        header("Location: admin_panel.php");
        exit;
    }

    public function mostrarHistorial(): void
    {
        SessionManager::requireLogin();

        $historial = $this->fortuneService->obtenerHistorialUsuario(
            (int) $_SESSION["usuario_id"]
        );

        $_SESSION["historial_galletas"] = $historial;

        header("Location: historial.php");
        exit;
    }
}