<?php $esAdmin = ($usuarioActual['rol'] ?? '') === 'admin'; ?>
<div class="panel-cabecera">
    <div>
        <h1 class="panel-titulo">Categorías</h1>
        <p class="panel-subtitulo">Géneros arquitectónicos con los que se clasifican los proyectos.</p>
    </div>
    <a class="btn btn-panel" href="<?= BASE_URL ?>/admin/categorias/crear"><i class="bi bi-plus-lg"></i> Nueva categoría</a>
</div>

<div class="panel-tarjeta">
    <div class="table-responsive">
        <table class="table panel-tabla align-middle mb-0">
            <thead>
                <tr><th>Nombre</th><th>Descripción</th><th class="text-center">Proyectos</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $c): ?>
                    <tr>
                        <td><a class="enlace-fila" href="<?= BASE_URL ?>/admin/categorias/editar/<?= (int) $c['id_categoria'] ?>"><?= Html::e($c['nombre']) ?></a></td>
                        <td class="texto-chico"><?= Html::e($c['descripcion']) ?></td>
                        <td class="text-center"><?= (int) $c['total_proyectos'] ?></td>
                        <td class="text-end text-nowrap">
                            <a class="btn-icono" title="Editar" href="<?= BASE_URL ?>/admin/categorias/editar/<?= (int) $c['id_categoria'] ?>"><i class="bi bi-pencil"></i></a>
                            <?php if ($esAdmin): ?>
                                <form class="d-inline" method="POST" action="<?= BASE_URL ?>/admin/categorias/eliminar/<?= (int) $c['id_categoria'] ?>"
                                      onsubmit="return confirm(<?= Html::e(json_encode('¿Eliminar la categoría «' . $c['nombre'] . '»?', JSON_UNESCAPED_UNICODE)) ?>)">
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
</div>
