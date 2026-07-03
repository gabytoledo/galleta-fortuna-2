<?php

require_once __DIR__ . "/../config/Database.php";

class HistorialRepository
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function guardarApertura(int $usuarioId, int $mensajeId, string $fechaApertura): bool
    {
        $sql = "INSERT INTO historial_galletas (usuario_id, mensaje_id, fecha_apertura)
                VALUES (:usuario_id, :mensaje_id, :fecha_apertura)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":usuario_id" => $usuarioId,
            ":mensaje_id" => $mensajeId,
            ":fecha_apertura" => $fechaApertura
        ]);
    }

    public function obtenerPorUsuario(int $usuarioId): array
    {
        $sql = "SELECT
                    h.id,
                    h.fecha_apertura,
                    m.texto AS mensaje
                FROM historial_galletas h
                INNER JOIN mensajes m ON h.mensaje_id = m.id
                WHERE h.usuario_id = :usuario_id
                ORDER BY h.fecha_apertura DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ":usuario_id" => $usuarioId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerCantidadAperturas(int $usuarioId): int
    {
        $sql = "SELECT COUNT(*) 
                FROM historial_galletas
                WHERE usuario_id = :usuario_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ":usuario_id" => $usuarioId
        ]);

        return (int)$stmt->fetchColumn();
    }

    public function obtenerUltimaGalleta(int $usuarioId): ?array
    {
        $sql = "SELECT
                    h.fecha_apertura,
                    m.texto AS mensaje
                FROM historial_galletas h
                INNER JOIN mensajes m
                    ON h.mensaje_id = m.id
                WHERE h.usuario_id = :usuario_id
                ORDER BY h.fecha_apertura DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ":usuario_id" => $usuarioId
        ]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado ?: null;
    }

    public function obtenerTopMensajesUsuario(int $usuarioId): array
    {
        $sql = "SELECT
                    m.texto,
                    COUNT(*) AS total
                FROM historial_galletas h
                INNER JOIN mensajes m
                    ON h.mensaje_id = m.id
                WHERE h.usuario_id = :usuario_id
                GROUP BY m.id, m.texto
                ORDER BY total DESC
                LIMIT 5";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ":usuario_id" => $usuarioId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}