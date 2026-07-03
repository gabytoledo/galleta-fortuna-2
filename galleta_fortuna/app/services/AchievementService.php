<?php

class AchievementService
{
    public static function obtenerLogros(int $cantidadAperturas): array
    {
        $logros = [
            [
                "nombre" => "Primer Paso",
                "icono" => "🏅",
                "descripcion" => "Abriste tu primera galleta.",
                "requisito" => 1
            ],
            [
                "nombre" => "Curioso",
                "icono" => "🍀",
                "descripcion" => "Abriste 10 galletas.",
                "requisito" => 10
            ],
            [
                "nombre" => "Sabio",
                "icono" => "🔮",
                "descripcion" => "Abriste 50 galletas.",
                "requisito" => 50
            ],
            [
                "nombre" => "Maestro de la Fortuna",
                "icono" => "👑",
                "descripcion" => "Abriste 100 galletas.",
                "requisito" => 100
            ]
        ];

        foreach ($logros as &$logro) {
            $logro["desbloqueado"] = $cantidadAperturas >= $logro["requisito"];
        }

        return $logros;
    }
}