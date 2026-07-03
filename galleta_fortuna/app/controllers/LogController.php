<?php

session_start();

class LogController
{
    public function mostrarLogs(): void
    {
        if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_rol"] !== "admin") {
            header("Location: login.php");
            exit;
        }

        $ruta = __DIR__ . "/../../logs/audit.log";

        if (file_exists($ruta)) {
            $_SESSION["contenido_logs"] = file_get_contents($ruta);
        } else {
            $_SESSION["contenido_logs"] = "Todavía no existe el archivo de logs.";
        }

        header("Location: ver_logs.php");
        exit;
    }
}