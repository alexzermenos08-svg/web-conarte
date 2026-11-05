<?php
$esAdmin  = ($usuarioActual['rol'] ?? '') === 'admin';
$atendido = (int) $mensaje['atendido'] === 1;
$wa       = Html::whatsapp($mensaje['telefono']);
?>
<div class="panel-cabecera">
    <div>
        <h1 class="panel-titulo">Mensaje de <?= Html::e($mensaje['nombre']) ?></h1>
        <p class="panel-subtitulo">Recibido el <?= Html::e(Html::fechaHora($mensaje['creado_en'])) ?></p>
    </div>
    <a class="btn btn-panel-sec" href="<?= BASE_URL ?>/admin/mensajes"><i class="bi bi-arrow-left"></i> Volver a mensajes</a>
</div>

<div class="panel-tarjeta" style="max-width: 760px;">
    <dl class="datos">
        <dt>Nombre</dt><dd><?= Html::e($mensaje['nombre']) ?></dd>
        <dt>Correo</dt><dd><a href="mailto:<?= Html::e($mensaje['correo']) ?>"><?= Html::e($mensaje['correo']) ?></a></dd>
        <dt>Teléfono</dt>
        <dd>
            <?php if ($mensaje['telefono']): ?>
                <?= Html::e($mensaje['telefono']) ?>
                <?php if ($wa): ?> · <a href="<?= Html::e($wa) ?>" target="_blank" rel="noopener">Abrir en WhatsApp</a><?php endif; ?>
            <?php else: ?>
                <span class="text-muted">No proporcionado</span>
            <?php endif; ?>
        </dd>
        <dt>Estado</dt>
        <dd><?= $atendido ? '<span class="estado estado-ok">Atendido</span>' : '<span class="estado estado-pendiente">Pendiente</span>' ?></dd>
    </dl>

    <h2 class="panel-seccion">Mensaje</h2>
    <div class="mensaje-texto"><?= nl2br(Html::e($mensaje['mensaje'])) ?></div>

    <div class="d-flex flex-wrap gap-2 mt-4">
        <a class="btn btn-panel" href="mailto:<?= Html::e($mensaje['correo']) ?>?subject=<?= rawurlencode('Respuesta a tu mensaje en ConArte') ?>"><i class="bi bi-reply"></i> Responder por correo</a>

        <form method="POST" action="<?= BASE_URL ?>/admin/mensajes/atender/<?= (int) $mensaje['id_contacto'] ?>">
            <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
            <?php if (!$atendido): ?><input type="hidden" name="atendido" value="1"><?php endif; ?>
            <button class="btn btn-panel-sec" type="submit">
                <?= $atendido ? '<i class="bi bi-arrow-counterclockwise"></i> Marcar como pendiente' : '<i class="bi bi-check2-circle"></i> Marcar como atendido' ?>
            </button>
        </form>

        <?php if ($esAdmin): ?>
            <form method="POST" action="<?= BASE_URL ?>/admin/mensajes/eliminar/<?= (int) $mensaje['id_contacto'] ?>" onsubmit="return confirm('¿Eliminar este mensaje?')">
                <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
                <button class="btn btn-peligro" type="submit"><i class="bi bi-trash"></i> Eliminar</button>
            </form>
        <?php endif; ?>
    </div>
</div>
