<?php
// Configuración de conexión a MySQL (MAMP local)
// IMPORTANTE: en producción (cPanel) estos valores cambian.
return [
    'host'     => '127.0.0.1',
    'port'     => '8889',       // Puerto de MySQL en MAMP (default MAMP: 8889, MySQL estándar: 3306)
    'dbname'   => 'conarte_db',
    'user'     => 'root',
    'password' => 'root',
    'charset'  => 'utf8mb4',
];
