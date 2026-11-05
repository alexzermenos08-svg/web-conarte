<div class="mb-4">
    <h1 class="panel-titulo">Resumen</h1>
    <p class="panel-subtitulo">Hola, <?= Html::e($usuarioActual['nombre']) ?>. Este es el estado actual del sitio.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <a class="metrica metrica-enlace" href="<?= BASE_URL ?>/admin/proyectos">
            <i class="bi bi-building metrica-icono"></i>
            <div class="metrica-numero"><?= (int) $resumen['proyectos'] ?></div>
            <div class="metrica-etiqueta">Proyectos publicados</div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <a class="metrica metrica-enlace" href="<?= BASE_URL ?>/admin/categorias">
            <i class="bi bi-tags metrica-icono"></i>
            <div class="metrica-numero"><?= (int) $resumen['categorias'] ?></div>
            <div class="metrica-etiqueta">Categorías</div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <a class="metrica metrica-enlace <?= (int) $resumen['mensajes_pendientes'] > 0 ? 'metrica-alerta' : '' ?>" href="<?= BASE_URL ?>/admin/mensajes?estado=pendientes">
            <i class="bi bi-envelope metrica-icono"></i>
            <div class="metrica-numero"><?= (int) $resumen['mensajes_pendientes'] ?></div>
            <div class="metrica-etiqueta">Mensajes sin atender</div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <a class="metrica metrica-enlace" href="<?= BASE_URL ?>/admin/carrusel">
            <i class="bi bi-images metrica-icono"></i>
            <div class="metrica-numero"><?= (int) $resumen['carrusel'] ?></div>
            <div class="metrica-etiqueta">Imágenes en el carrusel</div>
        </a>
    </div>
</div>

<div class="panel-tarjeta">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="panel-seccion mb-0">Últimos mensajes de contacto</h2>
        <a class="enlace-fila" href="<?= BASE_URL ?>/admin/mensajes">Ver todos</a>
    </div>

    <?php if (empty($ultimosContactos)): ?>
        <p class="text-muted mb-0">Aún no hay mensajes. Cuando alguien llene el formulario del sitio, aparecerá aquí.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table panel-tabla align-middle mb-0">
                <thead>
                    <tr><th>Fecha</th><th>Nombre</th><th>Correo</th><th>Mensaje</th><th>Estado</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($ultimosContactos as $contacto): ?>
                        <tr>
                            <td class="text-nowrap"><?= Html::e(Html::fechaHora($contacto['creado_en'])) ?></td>
                            <td><a class="enlace-fila" href="<?= BASE_URL ?>/admin/mensajes/ver/<?= (int) $contacto['id_contacto'] ?>"><?= Html::e($contacto['nombre']) ?></a></td>
                            <td><?= Html::e($contacto['correo']) ?></td>
                            <td><?= Html::e(mb_strimwidth($contacto['mensaje'], 0, 70, '…')) ?></td>
                            <td>
                                <?php if ((int) $contacto['atendido'] === 1): ?>
                                    <span class="estado estado-ok">Atendido</span>
                                <?php else: ?>
                                    <span class="estado estado-pendiente">Pendiente</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
