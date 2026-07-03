<?php

class AuthValidator
{
    public static function validarNombre(string $nombre): ?string
    {
        $nombre = trim($nombre);

        if ($nombre === "") {
            return "El nombre no puede estar vacío.";
        }

        if (strlen($nombre) < 3) {
            return "El nombre debe tener al menos 3 caracteres.";
        }

        if (strlen($nombre) > 50) {
            return "El nombre no puede superar los 50 caracteres.";
        }

        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $nombre)) {
            return "El nombre solo puede contener letras y espacios.";
        }

        return null;
    }

    public static function validarEmail(string $email): ?string
    {
        $email = trim($email);

        if ($email === "") {
            return "El email no puede estar vacío.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "El formato del email no es válido.";
        }

        return null;
    }

    public static function validarPassword(string $password): ?string
    {
        if ($password === "") {
            return "La contraseña no puede estar vacía.";
        }

        if (strlen($password) < 8) {
            return "La contraseña debe tener al menos 8 caracteres.";
        }

        if (!preg_match("/[A-Z]/", $password)) {
            return "La contraseña debe tener al menos una mayúscula.";
        }

        if (!preg_match("/[a-z]/", $password)) {
            return "La contraseña debe tener al menos una minúscula.";
        }

        if (!preg_match("/[0-9]/", $password)) {
            return "La contraseña debe tener al menos un número.";
        }

        return null;
    }

    public static function validarRegistro(string $nombre, string $email, string $password): ?string
    {
        $errorNombre = self::validarNombre($nombre);
        if ($errorNombre !== null) {
            return $errorNombre;
        }

        $errorEmail = self::validarEmail($email);
        if ($errorEmail !== null) {
            return $errorEmail;
        }

        $errorPassword = self::validarPassword($password);
        if ($errorPassword !== null) {
            return $errorPassword;
        }

        return null;
    }

    public static function validarLogin(string $email, string $password): ?string
    {
        $errorEmail = self::validarEmail($email);
        if ($errorEmail !== null) {
            return $errorEmail;
        }

        if (trim($password) === "") {
            return "La contraseña no puede estar vacía.";
        }

        return null;
    }
}