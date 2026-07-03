<?php

class WeatherService
{
    public static function obtenerClimaActual(?string $latitud = null, ?string $longitud = null): string
    {
        $usoUbicacionReal = true;

        if (empty($latitud) || empty($longitud)) {
            $latitud = "-34.6037";
            $longitud = "-58.3816";
            $usoUbicacionReal = false;
        }

        $ubicacion = self::obtenerNombreUbicacion($latitud, $longitud, $usoUbicacionReal);

        try {
            $url = "https://api.open-meteo.com/v1/forecast"
                . "?latitude=" . urlencode($latitud)
                . "&longitude=" . urlencode($longitud)
                . "&current_weather=true"
                . "&timezone=auto";

            $respuesta = self::obtenerRespuestaHttp($url);

            $datos = json_decode($respuesta, true);

            if (!isset($datos["current_weather"])) {
                return "Ubicación: {$ubicacion} - Clima no disponible.";
            }

            $temperatura = $datos["current_weather"]["temperature"] ?? "N/D";
            $viento = $datos["current_weather"]["windspeed"] ?? "N/D";
            $codigo = $datos["current_weather"]["weathercode"] ?? -1;

            $icono = self::obtenerIconoClima((int) $codigo);

            return "{$icono} Ubicación: {$ubicacion} - Temperatura: {$temperatura}°C - Viento: {$viento} km/h";

        } catch (Exception $e) {
            return "Ubicación: {$ubicacion} - No se pudo obtener el clima actual.";
        }
    }

    private static function obtenerNombreUbicacion(string $latitud, string $longitud, bool $usoUbicacionReal): string
    {
        if (!$usoUbicacionReal) {
            return "Buenos Aires, Argentina";
        }

        try {
            $url = "https://nominatim.openstreetmap.org/reverse"
                . "?format=json"
                . "&lat=" . urlencode($latitud)
                . "&lon=" . urlencode($longitud)
                . "&zoom=10"
                . "&addressdetails=1";

            $opciones = [
                "http" => [
                    "header" => "User-Agent: GalletaFortunaPro/1.0\r\n",
                    "timeout" => 5
                ]
            ];

            $contexto = stream_context_create($opciones);

            $respuesta = self::obtenerRespuestaHttp($url, $contexto);

            $datos = json_decode($respuesta, true);

            if (!isset($datos["address"])) {
                return "Ubicación detectada";
            }

            $address = $datos["address"];

            $ciudad = $address["city"]
                ?? $address["town"]
                ?? $address["village"]
                ?? $address["suburb"]
                ?? $address["county"]
                ?? "Ubicación detectada";

            $provincia = $address["state"] ?? "";
            $pais = $address["country"] ?? "";

            $partes = array_filter([$ciudad, $provincia, $pais]);

            return implode(", ", $partes);

        } catch (Exception $e) {
            return "Ubicación detectada";
        }
    }

    private static function obtenerRespuestaHttp(string $url, $contexto = null): string
    {
        $respuesta = file_get_contents($url, false, $contexto);

        if ($respuesta === false) {
            throw new Exception("No se pudo obtener respuesta HTTP.");
        }

        return $respuesta;
    }

    private static function obtenerIconoClima(int $codigo): string
    {
        return match (true) {
            $codigo === 0 => "☀️",
            in_array($codigo, [1, 2]) => "🌤️",
            $codigo === 3 => "☁️",
            in_array($codigo, [45, 48]) => "🌫️",
            in_array($codigo, [51, 53, 55, 56, 57]) => "🌦️",
            in_array($codigo, [61, 63, 65, 66, 67, 80, 81, 82]) => "🌧️",
            in_array($codigo, [71, 73, 75, 77, 85, 86]) => "❄️",
            in_array($codigo, [95, 96, 99]) => "⛈️",
            default => "🌡️"
        };
    }
}