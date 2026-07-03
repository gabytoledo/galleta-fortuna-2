<?php

require_once __DIR__ . "/WeatherService.php";
require_once __DIR__ . "/../repositories/MensajeRepository.php";
require_once __DIR__ . "/../repositories/HistorialRepository.php";
require_once __DIR__ . "/LogService.php";

class FortuneService
{
    private MensajeRepository $mensajeRepository;
    private HistorialRepository $historialRepository;

    public function __construct()
    {
        $this->mensajeRepository = new MensajeRepository();
        $this->historialRepository = new HistorialRepository();
    }

    public function abrirGalleta(int $usuarioId, ?string $latitud = null, ?string $longitud = null): ?array
    {
        date_default_timezone_set("America/Argentina/Buenos_Aires");

        $mensaje = $this->mensajeRepository->obtenerMensajeAleatorio();

        if ($mensaje === null) {
            return null;
        }

        $clima = WeatherService::obtenerClimaActual($latitud, $longitud);

        $fechaBaseDatos = date("Y-m-d H:i:s");
        $fechaPantalla = date("d/m/Y H:i:s");

        $this->historialRepository->guardarApertura(
            $usuarioId,
            $mensaje->getId(),
            $fechaBaseDatos
        );

        LogService::escribir(
            "GALLETA ABIERTA - Usuario ID: $usuarioId - Mensaje ID: " . $mensaje->getId()
        );

        return [
            "mensaje" => $mensaje->getTexto(),
            "fecha" => $fechaPantalla,
            "clima" => $clima
        ];
    }

    public function subirMensaje(string $texto): bool
    {
        return $this->mensajeRepository->guardarMensaje($texto);
    }

    public function obtenerTodasLasGalletas(): array
    {
        return $this->mensajeRepository->obtenerTodos();
    }

    public function obtenerGalletaPorId(int $id): ?array
    {
        return $this->mensajeRepository->buscarPorId($id);
    }

    public function actualizarGalleta(int $id, string $texto): bool
    {
        $texto = trim($texto);

        if ($id <= 0 || $texto === "") {
            return false;
        }

        return $this->mensajeRepository->actualizarPorId($id, $texto);
    }

    public function eliminarGalleta(int $id): bool
    {
        return $this->mensajeRepository->eliminarPorId($id);
    }

    public function obtenerHistorialUsuario(int $usuarioId): array
    {
        return $this->historialRepository->obtenerPorUsuario($usuarioId);
    }
}