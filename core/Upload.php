<?php

/**
 * Subida segura de imágenes (JPG, PNG o WebP).
 * - El tipo se detecta por el contenido real del archivo, no por su extensión.
 * - El archivo se guarda con un nombre aleatorio.
 * - Las fotos muy anchas se reducen a 2000 px para que el sitio cargue rápido.
 */
class Upload
{
    public const MAX_BYTES = 8388608; // 8 MB por imagen
    private const ANCHO_MAX = 2000;
    private const TIPOS = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    private const CARPETAS = ['proyectos', 'carrusel'];

    // Convierte $_FILES[$campo] (archivo simple o múltiple) en una lista de archivos individuales.
    public static function lista(string $campo): array
    {
        if (empty($_FILES[$campo])) {
            return [];
        }
        $f = $_FILES[$campo];
        if (!is_array($f['name'])) {
            return [$f];
        }
        $salida = [];
        foreach (array_keys($f['name']) as $i) {
            $salida[] = [
                'name'     => $f['name'][$i],
                'type'     => $f['type'][$i],
                'tmp_name' => $f['tmp_name'][$i],
                'error'    => $f['error'][$i],
                'size'     => $f['size'][$i],
            ];
        }
        return $salida;
    }

    // Guarda un archivo. Devuelve ['ok' => true, 'ruta' => 'assets/img/...'] o ['ok' => false, 'error' => '...'].
    public static function guardar(array $archivo, string $carpeta): array
    {
        if (!in_array($carpeta, self::CARPETAS, true)) {
            return self::fallo('Carpeta de destino no permitida.');
        }

        $nombre = (string) ($archivo['name'] ?? 'imagen');

        switch ($archivo['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return self::fallo("«{$nombre}» supera el límite del servidor (" . ini_get('upload_max_filesize') . ').');
            case UPLOAD_ERR_PARTIAL:
                return self::fallo("«{$nombre}» se subió incompleta. Intenta de nuevo.");
            default:
                return self::fallo("No se pudo subir «{$nombre}».");
        }

        if ($archivo['size'] > self::MAX_BYTES) {
            return self::fallo("«{$nombre}» pesa más de 8 MB. Reduce su tamaño e intenta de nuevo.");
        }
        if (!is_uploaded_file($archivo['tmp_name'])) {
            return self::fallo("«{$nombre}» no es una subida válida.");
        }

        $info = @getimagesize($archivo['tmp_name']);
        if ($info === false || !isset(self::TIPOS[$info['mime']])) {
            return self::fallo("«{$nombre}» no es una imagen JPG, PNG o WebP válida.");
        }
        if ($info[0] > 20000 || $info[1] > 20000) {
            return self::fallo("«{$nombre}» tiene dimensiones excesivas.");
        }

        $directorio = self::dirPublico() . '/assets/img/' . $carpeta;
        if (!is_dir($directorio) && !@mkdir($directorio, 0755, true)) {
            return self::fallo('No se pudo crear la carpeta de imágenes en el servidor.');
        }

        $archivoNuevo = bin2hex(random_bytes(10)) . '.' . self::TIPOS[$info['mime']];
        $destino      = $directorio . '/' . $archivoNuevo;

        if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
            return self::fallo('No se pudo guardar la imagen en el servidor.');
        }
        @chmod($destino, 0644);

        self::reducir($destino, $info['mime']);

        return ['ok' => true, 'ruta' => "assets/img/{$carpeta}/{$archivoNuevo}"];
    }

    // Borra del disco una imagen subida (solo dentro de las carpetas permitidas).
    public static function eliminar(?string $ruta): void
    {
        if (!$ruta || !preg_match('#^assets/img/(proyectos|carrusel)/[A-Za-z0-9_.-]+$#', $ruta)) {
            return;
        }
        $archivo = self::dirPublico() . '/' . $ruta;
        if (is_file($archivo)) {
            @unlink($archivo);
        }
    }

    private static function dirPublico(): string
    {
        return dirname(__DIR__) . '/public';
    }

    private static function fallo(string $mensaje): array
    {
        return ['ok' => false, 'error' => $mensaje];
    }

    // Reduce la imagen a ANCHO_MAX px si es más ancha. Si algo no se puede hacer con seguridad,
    // se conserva el original sin tocarlo.
    private static function reducir(string $ruta, string $mime): void
    {
        if (!function_exists('imagecreatetruecolor')) {
            return;
        }
        $dim = @getimagesize($ruta);
        if (!$dim || $dim[0] <= self::ANCHO_MAX || $dim[0] * $dim[1] > 16000000) {
            return;
        }
        // Al volver a guardar un JPG se pierde la orientación EXIF; sin esa extensión no la podemos corregir.
        if ($mime === 'image/jpeg' && !function_exists('exif_read_data')) {
            return;
        }

        $cargar = ['image/jpeg' => 'imagecreatefromjpeg', 'image/png' => 'imagecreatefrompng', 'image/webp' => 'imagecreatefromwebp'][$mime];
        if (!function_exists($cargar)) {
            return;
        }
        $origen = @$cargar($ruta);
        if (!$origen) {
            return;
        }

        if ($mime === 'image/jpeg') {
            $exif   = @exif_read_data($ruta);
            $angulo = [3 => 180, 6 => -90, 8 => 90][$exif['Orientation'] ?? 1] ?? 0;
            if ($angulo !== 0) {
                $girada = imagerotate($origen, $angulo, 0);
                if ($girada) {
                    $origen = $girada;
                }
            }
        }

        $ancho = imagesx($origen);
        $alto  = imagesy($origen);
        if ($ancho > self::ANCHO_MAX) {
            $nuevoAncho = self::ANCHO_MAX;
            $nuevoAlto  = (int) round($alto * self::ANCHO_MAX / $ancho);
        } else {
            $nuevoAncho = $ancho;
            $nuevoAlto  = $alto;
        }

        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        if ($mime !== 'image/jpeg') {
            imagealphablending($destino, false);
            imagesavealpha($destino, true);
        }
        imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($destino, $ruta, 85);
                break;
            case 'image/png':
                imagepng($destino, $ruta, 6);
                break;
            case 'image/webp':
                imagewebp($destino, $ruta, 85);
                break;
        }
    }
}
