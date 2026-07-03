<?php

require_once __DIR__ . "/../app/core/SessionManager.php";

SessionManager::start();

$page = $_GET["page"] ?? "home";

switch ($page) {
    case "home":
        require __DIR__ . "/home.php";
        break;

    case "fortune":
        require __DIR__ . "/fortune.php";
        break;

    case "history":
        require __DIR__ . "/historial_galletas.php";
        break;

    case "admin":
        require __DIR__ . "/admin_panel.php";
        break;

    case "logs":
        require __DIR__ . "/logs.php";
        break;

    case "upload":
        require __DIR__ . "/subir_galleta.php";
        break;

    default:
        require __DIR__ . "/home.php";
        break;
}