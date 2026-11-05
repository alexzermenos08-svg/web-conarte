<div class="panel-cabecera">
    <div>
        <h1 class="panel-titulo">Fotos del proyecto</h1>
        <p class="panel-subtitulo"><?= Html::e($proyecto['nombre']) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-panel-sec" href="<?= BASE_URL ?>/admin/proyectos/editar/<?= (int) $proyecto['id_proyecto'] ?>"><i class="bi bi-pencil"></i> Datos del proyecto</a>
        <a class="btn btn-panel-sec" href="<?= BASE_URL ?>/admin/proyectos"><i class="bi bi-arrow-left"></i> Volver al listado</a>
    </div>
</div>

<form class="panel-tarjeta mb-3" method="POST" enctype="multipart/form-data" action="<?= BASE_URL ?>/admin/proyectos/subirImagenes/<?= (int) $proyecto['id_proyecto'] ?>">
    <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
    <label class="form-label" for="imagenes">Agregar fotos</label>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <input class="form-control" style="max-width: 460px;" type="file" id="imagenes" name="imagenes[]" accept="image/jpeg,image/png,image/webp" multiple required>
        <button type="submit" class="btn btn-panel"><i class="bi bi-upload"></i> Subir</button>
    </div>
    <div class="form-text">JPG, PNG o WebP, hasta 8 MB cada una y 20 por envío. Se recomiendan fotos horizontales. La primera foto es la portada del proyecto.</div>
</form>

<div class="panel-tarjeta">
    <?php if (empty($imagenes)): ?>
        <p class="text-muted mb-0">Este proyecto todavía no tiene fotos.</p>
    <?php else: ?>
        <div class="galeria">
            <?php foreach ($imagenes as $i => $img): ?>
                <div class="galeria-item">
                    <div class="galeria-foto">
                        <img src="<?= BASE_URL . '/' . Html::e($img['ruta_archivo']) ?>" alt="<?= Html::e($img['texto_alt'] ?? '') ?>">
                        <?php if ($i === 0): ?><span class="galeria-portada">Portada</span><?php endif; ?>
                    </div>
                    <form class="mt-2" method="POST" action="<?= BASE_URL ?>/admin/proyectos/descripcionImagen/<?= (int) $img['id_imagen'] ?>">
                        <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="texto_alt" maxlength="150" placeholder="Descripción de la foto" value="<?= Html::e($img['texto_alt'] ?? '') ?>">
                            <button class="btn btn-panel-sec" type="submit" title="Guardar descripción"><i class="bi bi-check-lg"></i></button>
                        </div>
                    </form>
                    <div class="d-flex gap-2 mt-2">
                        <?php if ($i !== 0): ?>
                            <form method="POST" action="<?= BASE_URL ?>/admin/proyectos/portada/<?= (int) $img['id_imagen'] ?>">
                                <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
                                <button class="btn btn-sm btn-panel-sec" type="submit"><i class="bi bi-star"></i> Hacer portada</button>
                            </form>
                        <?php endif; ?>
                        <form method="POST" action="<?= BASE_URL ?>/admin/proyectos/eliminarImagen/<?= (int) $img['id_imagen'] ?>"
                              onsubmit="return confirm('¿Eliminar esta foto?')">
                            <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
                            <button class="btn btn-sm btn-peligro" type="submit"><i class="bi bi-trash"></i> Eliminar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
