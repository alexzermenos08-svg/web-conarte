<?php

// Mostrar errores en desarrollo (quitar/desactivar en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ruta base del sitio, calculada automáticamente.
// En local (MAMP) da algo como "/web-conarte/public"; en cPanel, si el sitio
// vive en la raíz del dominio, da "" (cadena vacía) y todo sigue funcionando igual.
define('BASE_URL', rtrim(str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']), '/'));

// Autoload manual sencillo (sin Composer) para las clases del core y modelos/controladores
spl_autoload_register(function ($class) {
    $paths = [
        dirname(__DIR__) . "/core/{$class}.php",
        dirname(__DIR__) . "/app/models/{$class}.php",
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require $path;
            return;
        }
    }
});

require dirname(__DIR__) . '/core/App.php';
require dirname(__DIR__) . '/core/Controller.php';
require dirname(__DIR__) . '/core/Database.php';

new App();
