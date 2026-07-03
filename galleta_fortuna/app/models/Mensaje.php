<?php

class Mensaje
{
    private int $id;
    private string $texto;

    public function __construct(int $id, string $texto)
    {
        $this->id = $id;
        $this->texto = $texto;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTexto(): string
    {
        return $this->texto;
    }
}