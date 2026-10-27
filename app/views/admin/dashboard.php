<div class="mb-4">
    <h1 class="panel-titulo">Resumen</h1>
    <p class="panel-subtitulo">Hola, <?= htmlspecialchars($usuarioActual['nombre']) ?>. Este es el estado actual del sitio.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="metrica">
            <i class="bi bi-building metrica-icono"></i>
            <div class="metrica-numero"><?= (int) $resumen['proyectos'] ?></div>
            <div class="metrica-etiqueta">Proyectos publicados</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="metrica">
            <i class="bi bi-tags metrica-icono"></i>
            <div class="metrica-numero"><?= (int) $resumen['categorias'] ?></div>
            <div class="metrica-etiqueta">Categorías</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="metrica <?= (int) $resumen['mensajes_pendientes'] > 0 ? 'metrica-alerta' : '' ?>">
            <i class="bi bi-envelope metrica-icono"></i>
            <div class="metrica-numero"><?= (int) $resumen['mensajes_pendientes'] ?></div>
            <div class="metrica-etiqueta">Mensajes sin atender</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="metrica">
            <i class="bi bi-images metrica-icono"></i>
            <div class="metrica-numero"><?= (int) $resumen['carrusel'] ?></div>
            <div class="metrica-etiqueta">Imágenes en el carrusel</div>
        </div>
    </div>
</div>

<div class="panel-tarjeta">
    <h2 class="panel-seccion">Últimos mensajes de contacto</h2>

    <?php if (empty($ultimosContactos)): ?>
        <p class="text-muted mb-0">Aún no hay mensajes. Cuando alguien llene el formulario del sitio, aparecerá aquí.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table panel-tabla align-middle mb-0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Mensaje</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ultimosContactos as $contacto): ?>
                        <tr>
                            <td class="text-nowrap"><?= date('d/m/Y H:i', strtotime($contacto['creado_en'])) ?></td>
                            <td><?= htmlspecialchars($contacto['nombre']) ?></td>
                            <td><?= htmlspecialchars($contacto['correo']) ?></td>
                            <td><?= htmlspecialchars(mb_strimwidth($contacto['mensaje'], 0, 70, '…')) ?></td>
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
