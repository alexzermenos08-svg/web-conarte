<?php

/** Utilidades pequeñas para las vistas. */
class Html
{
    private const MESES = [
        1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio',
        7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre',
    ];

    // Escapa texto para imprimirlo de forma segura en HTML.
    public static function e(mixed $valor): string
    {
        return htmlspecialchars((string) ($valor ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function url(string $ruta = ''): string
    {
        return BASE_URL . $ruta;
    }

    // "2023-10-01" → "octubre de 2023"
    public static function mesAnio(?string $fecha): string
    {
        if (!$fecha) {
            return '';
        }
        $t = strtotime($fecha);
        return $t ? self::MESES[(int) date('n', $t)] . ' de ' . date('Y', $t) : '';
    }

    // "2026-10-27 18:30:00" → "27/10/2026 18:30"
    public static function fechaHora(?string $fecha): string
    {
        $t = $fecha ? strtotime($fecha) : false;
        return $t ? date('d/m/Y H:i', $t) : '';
    }

    // Convierte un teléfono mexicano a enlace de WhatsApp; devuelve null si no es válido.
    public static function whatsapp(?string $telefono): ?string
    {
        $d = preg_replace('/\D+/', '', (string) $telefono);
        if (strlen($d) === 10) {
            return 'https://wa.me/52' . $d;
        }
        if (strlen($d) === 12 && str_starts_with($d, '52')) {
            return 'https://wa.me/' . $d;
        }
        return null;
    }
}
