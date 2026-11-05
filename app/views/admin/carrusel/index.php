<?php $activas = count(array_filter($imagenes, fn($i) => (int) $i['activo'] === 1)); ?>
<div class="panel-cabecera">
    <div>
        <h1 class="panel-titulo">Carrusel del encabezado</h1>
        <p class="panel-subtitulo">Fotos que rotan cada 4 segundos en la parte superior de la página de Inicio. <?= (int) $activas ?> activa(s).</p>
    </div>
</div>

<form class="panel-tarjeta mb-3" method="POST" enctype="multipart/form-data" action="<?= BASE_URL ?>/admin/carrusel/subir">
    <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
    <label class="form-label" for="imagenes">Agregar fotos</label>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <input class="form-control" style="max-width: 460px;" type="file" id="imagenes" name="imagenes[]" accept="image/jpeg,image/png,image/webp" multiple required>
        <button type="submit" class="btn btn-panel"><i class="bi bi-upload"></i> Subir</button>
    </div>
    <div class="form-text">Fotos horizontales de buena resolución (ideal 1920 × 800 px). JPG, PNG o WebP, hasta 8 MB cada una. Se recomiendan entre 3 y 6 fotos activas.</div>
</form>

<div class="panel-tarjeta">
    <?php if (empty($imagenes)): ?>
        <p class="text-muted mb-0">Todavía no hay fotos en el carrusel. Mientras no haya ninguna, el encabezado se muestra sin fotos.</p>
    <?php else: ?>
        <div class="d-flex flex-column gap-3">
            <?php foreach ($imagenes as $img): ?>
                <div class="carrusel-fila <?= (int) $img['activo'] === 1 ? '' : 'inactiva' ?>">
                    <img class="carrusel-miniatura" src="<?= BASE_URL . '/' . Html::e($img['ruta_archivo']) ?>" alt="<?= Html::e($img['texto_alt'] ?? '') ?>">
                    <form class="carrusel-datos" method="POST" action="<?= BASE_URL ?>/admin/carrusel/actualizar/<?= (int) $img['id_carrusel'] ?>">
                        <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label">Descripción</label>
                                <input type="text" class="form-control form-control-sm" name="texto_alt" maxlength="150" value="<?= Html::e($img['texto_alt'] ?? '') ?>">
                            </div>
                            <div class="col-6 col-md-2">
                                <label class="form-label">Orden</label>
                                <input type="number" class="form-control form-control-sm" name="orden" value="<?= (int) $img['orden'] ?>">
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" name="activo" value="1" id="act<?= (int) $img['id_carrusel'] ?>" <?= (int) $img['activo'] === 1 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="act<?= (int) $img['id_carrusel'] ?>">Activa</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-sm btn-panel-sec w-100" type="submit">Guardar</button>
                            </div>
                        </div>
                    </form>
                    <form method="POST" action="<?= BASE_URL ?>/admin/carrusel/eliminar/<?= (int) $img['id_carrusel'] ?>" onsubmit="return confirm('¿Eliminar esta foto del carrusel?')">
                        <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
                        <button class="btn-icono peligro" title="Eliminar" type="submit"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="texto-chico mt-3 mb-0">El orden va de menor a mayor: la foto con el número más bajo aparece primero.</p>
    <?php endif; ?>
</div>
