<?php

/** Mensajes que se muestran una sola vez después de una acción (guardado, error, etc.). */
class Flash
{
    public static function set(string $tipo, string $mensaje): void
    {
        Auth::iniciarSesion();
        $_SESSION['flash'][] = ['tipo' => $tipo, 'mensaje' => $mensaje];
    }

    public static function obtener(): array
    {
        Auth::iniciarSesion();
        $mensajes = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $mensajes;
    }
}
