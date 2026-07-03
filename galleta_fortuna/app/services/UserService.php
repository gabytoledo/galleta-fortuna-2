<?php

require_once __DIR__ . "/../repositories/UsuarioRepository.php";

class UserService
{
    private UsuarioRepository $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
    }

    public function obtenerTodosLosUsuarios(): array
    {
        return $this->usuarioRepository->obtenerTodos();
    }
}