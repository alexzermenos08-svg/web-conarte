<?php $seccion = $seccion ?? 'resumen'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= htmlspecialchars($titulo ?? 'Panel') ?> — Panel ConArte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
</head>
<body>

<div class="panel">
    <aside class="panel-lateral">
        <a class="panel-marca" href="<?= BASE_URL ?>/admin">
            <span class="panel-marca-logo"><img src="<?= BASE_URL ?>/assets/img/logo.jpeg" alt="ConArte"></span>
            <span class="panel-marca-texto">Panel de administración</span>
        </a>

        <nav class="panel-menu">
            <a class="panel-enlace <?= $seccion === 'resumen' ? 'activo' : '' ?>" href="<?= BASE_URL ?>/admin">
                <i class="bi bi-speedometer2"></i> Resumen
            </a>
            <span class="panel-enlace deshabilitado"><i class="bi bi-building"></i> Proyectos <em>pronto</em></span>
            <span class="panel-enlace deshabilitado"><i class="bi bi-tags"></i> Categorías <em>pronto</em></span>
            <span class="panel-enlace deshabilitado"><i class="bi bi-images"></i> Carrusel <em>pronto</em></span>
            <span class="panel-enlace deshabilitado"><i class="bi bi-envelope"></i> Mensajes <em>pronto</em></span>
            <a class="panel-enlace" href="<?= BASE_URL ?>/" target="_blank" rel="noopener">
                <i class="bi bi-box-arrow-up-right"></i> Ver el sitio
            </a>
        </nav>

        <div class="panel-usuario">
            <div class="panel-usuario-nombre"><?= htmlspecialchars($usuarioActual['nombre']) ?></div>
            <div class="panel-usuario-rol"><?= htmlspecialchars($usuarioActual['rol']) ?></div>
            <form action="<?= BASE_URL ?>/admin/logout" method="POST">
                <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
                <button type="submit" class="btn-cerrar"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <main class="panel-contenido">
