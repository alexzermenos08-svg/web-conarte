<?php
$rutaActual = trim(substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), strlen(BASE_URL)), '/');
$seccionActual = explode('/', $rutaActual)[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConArte Construcciones — Arquitectura y Construcción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/estilos.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-conarte sticky-top">
  <div class="container">
    <a class="navbar-brand" href="<?= BASE_URL ?>/">
      <span class="logo-badge"><img src="<?= BASE_URL ?>/assets/img/logo.jpeg" alt="ConArte Construcciones"></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navConarte" aria-label="Abrir menú">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navConarte">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link <?= $seccionActual === '' ? 'active' : '' ?>" href="<?= BASE_URL ?>/">Inicio</a></li>
        <li class="nav-item"><a class="nav-link <?= $seccionActual === 'proyectos' ? 'active' : '' ?>" href="<?= BASE_URL ?>/proyectos">Portafolio</a></li>
        <li class="nav-item"><a class="nav-link <?= $seccionActual === 'trayectoria' ? 'active' : '' ?>" href="<?= BASE_URL ?>/trayectoria">Trayectoria</a></li>
        <li class="nav-item"><a class="nav-link <?= $seccionActual === 'contacto' ? 'active' : '' ?>" href="<?= BASE_URL ?>/contacto">Contacto</a></li>
      </ul>
    </div>
  </div>
</nav>
