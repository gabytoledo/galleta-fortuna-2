<?php

class Database
{
    private ?PDO $conn = null;

    public function conectar(): PDO
    {
        if ($this->conn === null) {
            try {
                $config = require __DIR__ . "/config.php";

                $db = $config["database"];

                $dsn = "mysql:host={$db["host"]};dbname={$db["name"]};charset={$db["charset"]}";

                $this->conn = new PDO(
                    $dsn,
                    $db["user"],
                    $db["password"]
                );

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Error de conexión con la base de datos.");
            }
        }

        return $this->conn;
    }
}