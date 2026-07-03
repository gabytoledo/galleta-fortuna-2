<?php

require_once __DIR__ . "/../repositories/EstadisticaRepository.php";

class EstadisticaService
{
    private EstadisticaRepository $estadisticaRepository;

    public function __construct()
    {
        $this->estadisticaRepository = new EstadisticaRepository();
    }

    public function obtenerDashboard(): array
{
    return [
        "resumen" => $this->estadisticaRepository->obtenerResumen(),
        "topMensajes" => $this->estadisticaRepository->obtenerTopMensajes(),
        "topUsuarios" => $this->estadisticaRepository->obtenerTopUsuarios(),
        "ultimaActividad" => $this->estadisticaRepository->obtenerUltimaActividad()
    ];
}
}