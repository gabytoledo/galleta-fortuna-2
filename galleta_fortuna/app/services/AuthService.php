<?php
require_once __DIR__ . "/LogService.php";
require_once __DIR__ . "/../repositories/UsuarioRepository.php";
require_once __DIR__ . "/../models/Usuario.php";
require_once __DIR__ . "/../validators/AuthValidator.php";

class AuthService
{
    private UsuarioRepository $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
    }

    public function registrar(string $nombre, string $email, string $password): array
    {
        $error = AuthValidator::validarRegistro($nombre, $email, $password);

        if ($error !== null) {
            return [
                "success" => false,
                "message" => $error
            ];
        }

        $usuarioExistente = $this->usuarioRepository->buscarPorEmail($email);

        if ($usuarioExistente !== null) {
            return [
                "success" => false,
                "message" => "El email ya está registrado."
            ];
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $usuario = new Usuario(null, trim($nombre), trim($email), $passwordHash);

        $guardado = $this->usuarioRepository->guardar($usuario);

        if ($guardado) {
    LogService::escribir(
        "REGISTRO EXITOSO - Usuario: " . trim($email)
    );
} else {
    LogService::escribir(
        "REGISTRO FALLIDO - Usuario: " . trim($email)
    );
}

return [
    "success" => $guardado,
    "message" => $guardado ? "Usuario registrado correctamente." : "Error al guardar el usuario."
];

    }

    public function login(string $email, string $password): array
    {
        $error = AuthValidator::validarLogin($email, $password);

        if ($error !== null) {
            return [
                "success" => false,
                "message" => $error,
                "usuario" => null
            ];
        }

        $usuario = $this->usuarioRepository->buscarPorEmail($email);

      if ($usuario === null || !password_verify($password, $usuario["password"])) {

    LogService::escribir(
        "LOGIN FALLIDO - Usuario: " . trim($email)
    );

    return [
        "success" => false,
        "message" => "Email o contraseña incorrectos.",
        "usuario" => null
    ];
}

LogService::escribir(
    "LOGIN EXITOSO - Usuario: " . trim($email)
);

return [
    "success" => true,
    "message" => "Login correcto.",
    "usuario" => $usuario
];

        return [
            "success" => true,
            "message" => "Login correcto.",
            "usuario" => $usuario
        ];
    }

   public function registrarAdmin(string $nombre, string $email, string $password): array
{
    $error = AuthValidator::validarRegistro($nombre, $email, $password);

    if ($error !== null) {
        return [
            "success" => false,
            "message" => $error
        ];
    }

    $usuarioExistente = $this->usuarioRepository->buscarPorEmail($email);

    if ($usuarioExistente !== null) {
        return [
            "success" => false,
            "message" => "El email ya está registrado."
        ];
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $usuario = new Usuario(
        null,
        trim($nombre),
        trim($email),
        $passwordHash
    );

    $guardado = $this->usuarioRepository->guardarAdmin($usuario);

    return [
        "success" => $guardado,
        "message" => $guardado
            ? "Administrador registrado correctamente."
            : "No se pudo registrar el administrador."
    ];
}


}