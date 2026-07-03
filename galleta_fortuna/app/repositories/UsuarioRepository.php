<?php

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/Usuario.php";

class UsuarioRepository
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function guardar(Usuario $usuario): bool
    {
        $sql = "INSERT INTO usuarios (nombre, email, password) 
                VALUES (:nombre, :email, :password)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":nombre" => $usuario->getNombre(),
            ":email" => $usuario->getEmail(),
            ":password" => $usuario->getPassword()
        ]);
    }

    public function guardarAdmin(Usuario $usuario): bool
    {
        $sql = "INSERT INTO usuarios (nombre, email, password, rol)
                VALUES (:nombre, :email, :password, 'admin')";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":nombre" => $usuario->getNombre(),
            ":email" => $usuario->getEmail(),
            ":password" => $usuario->getPassword()
        ]);
    }

    public function buscarPorEmail(string $email): ?array
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ":email" => $email
        ]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $usuario ?: null;
    }

    public function obtenerTodos(): array
    {
        $sql = "SELECT id, nombre, email, rol FROM usuarios ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarRolPorId(int $id, string $rol): bool
    {
        $sql = "UPDATE usuarios SET rol = :rol WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":rol" => $rol,
            ":id" => $id
        ]);
    }
}