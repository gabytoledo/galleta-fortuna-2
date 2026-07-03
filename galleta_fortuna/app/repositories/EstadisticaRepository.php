<?php

require_once __DIR__ . "/../config/Database.php";

class EstadisticaRepository
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function obtenerResumen(): array
    {
        $usuarios = $this->conn->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
        $mensajes = $this->conn->query("SELECT COUNT(*) FROM mensajes")->fetchColumn();
        $aperturas = $this->conn->query("SELECT COUNT(*) FROM historial_galletas")->fetchColumn();

        return [
            "usuarios" => $usuarios,
            "mensajes" => $mensajes,
            "aperturas" => $aperturas
        ];
    }

    public function obtenerTopMensajes(): array
    {
        $sql = "SELECT 
                    m.texto,
                    COUNT(h.id) AS total
                FROM historial_galletas h
                INNER JOIN mensajes m ON h.mensaje_id = m.id
                GROUP BY m.id, m.texto
                ORDER BY total DESC
                LIMIT 5";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerTopUsuarios(): array
    {
        $sql = "SELECT 
                    u.nombre,
                    u.email,
                    COUNT(h.id) AS total
                FROM historial_galletas h
                INNER JOIN usuarios u ON h.usuario_id = u.id
                GROUP BY u.id, u.nombre, u.email
                ORDER BY total DESC
                LIMIT 3";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function obtenerUltimaActividad(): ?array
{
    $sql = "SELECT 
                h.fecha_apertura,
                m.texto AS mensaje,
                u.nombre AS usuario,
                u.email
            FROM historial_galletas h
            INNER JOIN mensajes m ON h.mensaje_id = m.id
            INNER JOIN usuarios u ON h.usuario_id = u.id
            ORDER BY h.fecha_apertura DESC
            LIMIT 1";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    return $resultado ?: null;
}


}