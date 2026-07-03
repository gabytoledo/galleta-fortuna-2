<?php

class SessionManager
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function requireLogin(): void
    {
        self::start();

        if (!isset($_SESSION["usuario_id"])) {
            header("Location: login.php");
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        self::start();

        if (
            !isset($_SESSION["usuario_id"]) ||
            ($_SESSION["usuario_rol"] ?? "") !== "admin"
        ) {
            header("Location: login.php");
            exit;
        }
    }
}