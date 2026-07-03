<?php

class Usuario
{
    private ?int $id;
    private string $nombre;
    private string $email;
    private string $password;

    public function __construct(?int $id, string $nombre, string $email, string $password)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}