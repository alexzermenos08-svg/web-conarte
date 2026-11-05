<div class="panel-cabecera">
    <div>
        <h1 class="panel-titulo"><?= Html::e($titulo) ?></h1>
        <p class="panel-subtitulo">Los campos con * son obligatorios.</p>
    </div>
</div>

<?php if (!empty($errores)): ?>
    <div class="alert alert-danger py-2">
        <ul class="mb-0">
            <?php foreach ($errores as $error): ?><li><?= Html::e($error) ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form class="panel-tarjeta" method="POST" action="<?= BASE_URL . Html::e($accion) ?>" style="max-width: 640px;">
    <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">

    <div class="mb-3">
        <label class="form-label" for="nombre">Nombre *</label>
        <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" required value="<?= Html::e($categoria['nombre']) ?>">
    </div>
    <div class="mb-4">
        <label class="form-label" for="descripcion">Descripción</label>
        <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="255" value="<?= Html::e($categoria['descripcion']) ?>">
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-panel">Guardar</button>
        <a class="btn btn-panel-sec" href="<?= BASE_URL ?>/admin/categorias">Cancelar</a>
    </div>
</form>
