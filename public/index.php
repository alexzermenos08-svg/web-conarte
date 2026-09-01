<?php

// Mostrar errores en desarrollo (quitar/desactivar en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

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
