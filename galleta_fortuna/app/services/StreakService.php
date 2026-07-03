<?php

class StreakService
{
    public static function calcularRacha(array $fechas): int
    {
        if (empty($fechas)) {
            return 0;
        }

        date_default_timezone_set("America/Argentina/Buenos_Aires");

        $racha = 0;
        $diaActual = new DateTime(date("Y-m-d"));

        foreach ($fechas as $fecha) {
            $fechaApertura = new DateTime($fecha);

            if ($fechaApertura->format("Y-m-d") === $diaActual->format("Y-m-d")) {
                $racha++;
                $diaActual->modify("-1 day");
                continue;
            }

            if ($fechaApertura->format("Y-m-d") === $diaActual->format("Y-m-d")) {
                $racha++;
                $diaActual->modify("-1 day");
                continue;
            }

            break;
        }

        return $racha;
    }
}