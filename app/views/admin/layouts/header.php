<?php
$seccion  = $seccion ?? 'resumen';
$esAdmin  = ($usuarioActual['rol'] ?? '') === 'admin';
$menu = [
    ['resumen',    '/admin',            'bi-speedometer2', 'Resumen'],
    ['proyectos',  '/admin/proyectos',  'bi-building',     'Proyectos'],
    ['categorias', '/admin/categorias', 'bi-tags',         'Categorías'],
    ['carrusel',   '/admin/carrusel',   'bi-images',       'Carrusel'],
    ['mensajes',   '/admin/mensajes',   'bi-envelope',     'Mensajes'],
];
if ($esAdmin) {
    $menu[] = ['usuarios', '/admin/usuarios', 'bi-people', 'Usuarios'];
}
$claseAlerta = ['exito' => 'success', 'error' => 'danger', 'aviso' => 'warning'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= Html::e($titulo ?? 'Panel') ?> — Panel ConArte</title>
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
            <?php foreach ($menu as [$clave, $ruta, $icono, $texto]): ?>
                <a class="panel-enlace <?= $seccion === $clave ? 'activo' : '' ?>" href="<?= BASE_URL . $ruta ?>">
                    <i class="bi <?= $icono ?>"></i> <?= $texto ?>
                    <?php if ($clave === 'mensajes' && ($pendientes ?? 0) > 0): ?>
                        <em class="insignia"><?= (int) $pendientes ?></em>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
            <a class="panel-enlace" href="<?= BASE_URL ?>/" target="_blank" rel="noopener">
                <i class="bi bi-box-arrow-up-right"></i> Ver el sitio
            </a>
        </nav>

        <div class="panel-usuario">
            <div class="panel-usuario-nombre"><?= Html::e($usuarioActual['nombre']) ?></div>
            <div class="panel-usuario-rol"><?= Html::e($usuarioActual['rol']) ?></div>
            <a class="panel-enlace <?= $seccion === 'perfil' ? 'activo' : '' ?> mb-2" href="<?= BASE_URL ?>/admin/perfil">
                <i class="bi bi-person-gear"></i> Mi cuenta
            </a>
            <form action="<?= BASE_URL ?>/admin/logout" method="POST">
                <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
                <button type="submit" class="btn-cerrar"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <main class="panel-contenido">
        <?php foreach (($mensajes ?? []) as $m): ?>
            <div class="alert alert-<?= $claseAlerta[$m['tipo']] ?? 'info' ?> py-2" role="alert"><?= Html::e($m['mensaje']) ?></div>
        <?php endforeach; ?>
