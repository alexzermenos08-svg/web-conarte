<div class="panel-cabecera">
    <div>
        <h1 class="panel-titulo"><?= Html::e($titulo) ?></h1>
        <p class="panel-subtitulo">Los campos con * son obligatorios.</p>
    </div>
    <?php if ($idProyecto): ?>
        <a class="btn btn-panel-sec" href="<?= BASE_URL ?>/admin/proyectos/imagenes/<?= (int) $idProyecto ?>"><i class="bi bi-images"></i> Administrar fotos</a>
    <?php endif; ?>
</div>

<?php if (!empty($errores)): ?>
    <div class="alert alert-danger py-2">
        <ul class="mb-0">
            <?php foreach ($errores as $error): ?><li><?= Html::e($error) ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form class="panel-tarjeta" method="POST" action="<?= BASE_URL . Html::e($accion) ?>">
    <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">

    <div class="mb-3">
        <label class="form-label" for="nombre">Nombre del proyecto *</label>
        <input type="text" class="form-control" id="nombre" name="nombre" maxlength="150" required value="<?= Html::e($proyecto['nombre']) ?>">
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="id_categoria">Categoría *</label>
            <select class="form-select" id="id_categoria" name="id_categoria" required>
                <option value="">Selecciona…</option>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= (int) $c['id_categoria'] ?>" <?= (int) $proyecto['id_categoria'] === (int) $c['id_categoria'] ? 'selected' : '' ?>>
                        <?= Html::e($c['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="fecha_proyecto">Fecha del proyecto</label>
            <input type="date" class="form-control" id="fecha_proyecto" name="fecha_proyecto" value="<?= Html::e($proyecto['fecha_proyecto']) ?>">
            <div class="form-text">En el sitio se muestra solo el mes y el año.</div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label" for="ubicacion">Ubicación</label>
        <input type="text" class="form-control" id="ubicacion" name="ubicacion" maxlength="150" placeholder="Ej. Tecomán, Col." value="<?= Html::e($proyecto['ubicacion']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label" for="descripcion">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="5" maxlength="5000"><?= Html::e($proyecto['descripcion']) ?></textarea>
    </div>

    <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" id="destacado" name="destacado" value="1" <?= !empty($proyecto['destacado']) ? 'checked' : '' ?>>
        <label class="form-check-label" for="destacado">Mostrar como proyecto destacado en la página de Inicio</label>
        <div class="form-text">En Inicio se muestran los 6 destacados más recientes.</div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-panel">Guardar</button>
        <a class="btn btn-panel-sec" href="<?= BASE_URL ?>/admin/proyectos">Cancelar</a>
    </div>
</form>
