<?php
$pestanas = ['todos' => 'Todos', 'pendientes' => 'Pendientes', 'atendidos' => 'Atendidos'];
$esAdmin  = ($usuarioActual['rol'] ?? '') === 'admin';
?>
<div class="panel-cabecera">
    <div>
        <h1 class="panel-titulo">Mensajes de contacto</h1>
        <p class="panel-subtitulo">Mensajes enviados desde el formulario del sitio.</p>
    </div>
</div>

<ul class="nav pestanas mb-3">
    <?php foreach ($pestanas as $clave => $texto): ?>
        <li class="nav-item">
            <a class="nav-link <?= $estado === $clave ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/mensajes?estado=<?= $clave ?>"><?= $texto ?></a>
        </li>
    <?php endforeach; ?>
</ul>

<div class="panel-tarjeta">
    <?php if (empty($filas)): ?>
        <p class="text-muted mb-0">No hay mensajes en esta vista.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table panel-tabla align-middle mb-0">
                <thead>
                    <tr><th>Fecha</th><th>Nombre</th><th>Correo</th><th>Mensaje</th><th>Estado</th><th class="text-end">Acciones</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($filas as $m): ?>
                        <tr class="<?= (int) $m['atendido'] === 0 ? 'fila-pendiente' : '' ?>">
                            <td class="text-nowrap"><?= Html::e(Html::fechaHora($m['creado_en'])) ?></td>
                            <td><a class="enlace-fila" href="<?= BASE_URL ?>/admin/mensajes/ver/<?= (int) $m['id_contacto'] ?>"><?= Html::e($m['nombre']) ?></a></td>
                            <td><?= Html::e($m['correo']) ?></td>
                            <td><?= Html::e(mb_strimwidth($m['mensaje'], 0, 70, '…')) ?></td>
                            <td>
                                <?php if ((int) $m['atendido'] === 1): ?>
                                    <span class="estado estado-ok">Atendido</span>
                                <?php else: ?>
                                    <span class="estado estado-pendiente">Pendiente</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end text-nowrap">
                                <a class="btn-icono" title="Ver" href="<?= BASE_URL ?>/admin/mensajes/ver/<?= (int) $m['id_contacto'] ?>"><i class="bi bi-eye"></i></a>
                                <?php if ($esAdmin): ?>
                                    <form class="d-inline" method="POST" action="<?= BASE_URL ?>/admin/mensajes/eliminar/<?= (int) $m['id_contacto'] ?>" onsubmit="return confirm('¿Eliminar este mensaje?')">
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
        $rutaBase = '/admin/mensajes';
        $consulta = ['estado' => $estado];
        require __DIR__ . '/../partials/paginacion.php';
        ?>
    <?php endif; ?>
</div>
