<?php $esAdmin = ($usuarioActual['rol'] ?? '') === 'admin'; ?>
<div class="panel-cabecera">
    <div>
        <h1 class="panel-titulo">Proyectos</h1>
        <p class="panel-subtitulo"><?= (int) $total ?> proyecto(s)<?= ($busqueda !== '' || $idCategoria > 0) ? ' con el filtro aplicado' : '' ?></p>
    </div>
    <a class="btn btn-panel" href="<?= BASE_URL ?>/admin/proyectos/crear"><i class="bi bi-plus-lg"></i> Nuevo proyecto</a>
</div>

<form class="panel-tarjeta filtros" method="GET" action="<?= BASE_URL ?>/admin/proyectos">
    <div class="row g-2 align-items-end">
        <div class="col-md-5">
            <label class="form-label" for="q">Buscar</label>
            <input type="search" class="form-control" id="q" name="q" placeholder="Nombre o ubicación" value="<?= Html::e($busqueda) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="categoria">Categoría</label>
            <select class="form-select" id="categoria" name="categoria">
                <option value="0">Todas</option>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= (int) $c['id_categoria'] ?>" <?= $idCategoria === (int) $c['id_categoria'] ? 'selected' : '' ?>>
                        <?= Html::e($c['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-panel-sec flex-fill" type="submit">Buscar</button>
            <a class="btn btn-panel-sec flex-fill" href="<?= BASE_URL ?>/admin/proyectos">Limpiar</a>
        </div>
    </div>
</form>

<div class="panel-tarjeta mt-3">
    <?php if (empty($filas)): ?>
        <p class="text-muted mb-0">No se encontraron proyectos.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table panel-tabla align-middle mb-0">
                <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Categoría</th>
                        <th>Fecha</th>
                        <th class="text-center">Fotos</th>
                        <th class="text-center">Destacado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filas as $p): ?>
                        <tr>
                            <td>
                                <a class="enlace-fila" href="<?= BASE_URL ?>/admin/proyectos/editar/<?= (int) $p['id_proyecto'] ?>"><?= Html::e($p['nombre']) ?></a>
                                <?php if ($p['ubicacion']): ?><div class="texto-chico"><?= Html::e($p['ubicacion']) ?></div><?php endif; ?>
                            </td>
                            <td><?= Html::e($p['categoria_nombre']) ?></td>
                            <td class="text-nowrap"><?= Html::e(Html::mesAnio($p['fecha_proyecto'])) ?></td>
                            <td class="text-center"><?= (int) $p['total_imagenes'] ?></td>
                            <td class="text-center"><?= (int) $p['destacado'] === 1 ? '<i class="bi bi-star-fill estrella"></i>' : '<span class="text-muted">—</span>' ?></td>
                            <td class="text-end text-nowrap">
                                <a class="btn-icono" title="Fotos" href="<?= BASE_URL ?>/admin/proyectos/imagenes/<?= (int) $p['id_proyecto'] ?>"><i class="bi bi-images"></i></a>
                                <a class="btn-icono" title="Editar" href="<?= BASE_URL ?>/admin/proyectos/editar/<?= (int) $p['id_proyecto'] ?>"><i class="bi bi-pencil"></i></a>
                                <a class="btn-icono" title="Ver en el sitio" target="_blank" rel="noopener" href="<?= BASE_URL ?>/proyectos/ver/<?= (int) $p['id_proyecto'] ?>"><i class="bi bi-box-arrow-up-right"></i></a>
                                <?php if ($esAdmin): ?>
                                    <form class="d-inline" method="POST" action="<?= BASE_URL ?>/admin/proyectos/eliminar/<?= (int) $p['id_proyecto'] ?>"
                                          onsubmit="return confirm(<?= Html::e(json_encode('¿Eliminar el proyecto «' . $p['nombre'] . '» y todas sus fotos? Esta acción no se puede deshacer.', JSON_UNESCAPED_UNICODE)) ?>)">
                                        <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
                                        <button class="btn-icono peligro" title="Eliminar" type="submit"><i class="bi bi-trash"></i></button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
        $rutaBase = '/admin/proyectos';
        $consulta = array_filter(['q' => $busqueda, 'categoria' => $idCategoria ?: null], fn($v) => $v !== '' && $v !== null);
        require __DIR__ . '/../partials/paginacion.php';
        ?>
    <?php endif; ?>
</div>
