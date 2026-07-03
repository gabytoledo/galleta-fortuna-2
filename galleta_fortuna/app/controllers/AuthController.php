<?php

session_start();

require_once __DIR__ . "/../services/AuthService.php";

class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function registrar(): void
    {
        $nombre = $_POST["nombre"] ?? "";
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";

        $resultado = $this->authService->registrar($nombre, $email, $password);

        if ($resultado["success"]) {
            header("Location: login.php?success=registro");
            exit;
        }

        $_SESSION["error_registro"] = $resultado["message"];
        header("Location: register.php");
        exit;
    }

    public function login(): void
    {
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";

        $resultado = $this->authService->login($email, $password);

        if ($resultado["success"]) {
            $usuario = $resultado["usuario"];

            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nombre"] = $usuario["nombre"];
            $_SESSION["usuario_rol"] = $usuario["rol"];
            header("Location: home.php");
            exit;
        }

        $_SESSION["error_login"] = $resultado["message"];
        header("Location: login.php");
        exit;
    } 
    
     public function registrarAdmin(): void
{
    if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_rol"] !== "admin") {
        header("Location: login.php");
        exit;
    }

    $nombre = $_POST["nombre"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $resultado = $this->authService->registrarAdmin($nombre, $email, $password);

    if ($resultado["success"]) {
        $_SESSION["admin_success"] = $resultado["message"];
    } else {
        $_SESSION["admin_error"] = $resultado["message"];
    }

    header("Location: admin_panel.php");
    exit;
    }   



}