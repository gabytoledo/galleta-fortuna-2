<?php

require_once __DIR__ . "/../config/Database.php";

class FavoritoRepository
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function guardar(int $usuarioId, string $mensajeTexto): bool
    {
        date_default_timezone_set("America/Argentina/Buenos_Aires");

        $sql = "INSERT INTO favoritos (usuario_id, mensaje_texto, fecha_guardado)
                VALUES (:usuario_id, :mensaje_texto, :fecha_guardado)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":usuario_id" => $usuarioId,
            ":mensaje_texto" => $mensajeTexto,
            ":fecha_guardado" => date("Y-m-d H:i:s")
        ]);
    }

    public function obtenerPorUsuario(int $usuarioId): array
    {
        $sql = "SELECT *
                FROM favoritos
                WHERE usuario_id = :usuario_id
                ORDER BY fecha_guardado DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ":usuario_id" => $usuarioId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}