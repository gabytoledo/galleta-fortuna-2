<?php

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/Mensaje.php";

class MensajeRepository
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function obtenerMensajeAleatorio(): ?Mensaje
    {
        $sql = "SELECT * FROM mensajes ORDER BY RAND() LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Mensaje(
            $data["id"],
            $data["texto"]
        );
    }

    public function guardarMensaje(string $texto): bool
    {
        $sql = "INSERT INTO mensajes (texto) VALUES (:texto)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":texto" => $texto
        ]);
    }

    public function obtenerTodos(): array
    {
        $sql = "SELECT * FROM mensajes ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT * FROM mensajes WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ":id" => $id
        ]);

        $mensaje = $stmt->fetch(PDO::FETCH_ASSOC);

        return $mensaje ?: null;
    }

    public function actualizarPorId(int $id, string $texto): bool
    {
        $sql = "UPDATE mensajes SET texto = :texto WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":texto" => $texto,
            ":id" => $id
        ]);
    }

    public function eliminarPorId(int $id): bool
    {
        try {
            $this->conn->beginTransaction();

            $sqlHistorial = "DELETE FROM historial_galletas WHERE mensaje_id = :id";
            $stmtHistorial = $this->conn->prepare($sqlHistorial);
            $stmtHistorial->execute([
                ":id" => $id
            ]);

            $sqlMensaje = "DELETE FROM mensajes WHERE id = :id";
            $stmtMensaje = $this->conn->prepare($sqlMensaje);
            $stmtMensaje->execute([
                ":id" => $id
            ]);

            $this->conn->commit();

            return true;

        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}