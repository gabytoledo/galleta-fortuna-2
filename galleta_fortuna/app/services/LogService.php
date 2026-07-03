<?php

class LogService
{
    public static function escribir(string $mensaje): void
    {
        date_default_timezone_set("America/Argentina/Buenos_Aires");

        $fecha = date("Y-m-d H:i:s");

        $ruta = __DIR__ . "/../../logs/audit.log";

        if (!file_exists(dirname($ruta))) {
            mkdir(dirname($ruta), 0777, true);
        }

        file_put_contents(
            $ruta,
            "[$fecha] $mensaje" . PHP_EOL,
            FILE_APPEND
        );
    }
}
