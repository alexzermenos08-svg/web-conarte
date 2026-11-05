<div class="panel-cabecera">
    <div>
        <h1 class="panel-titulo">Mi cuenta</h1>
        <p class="panel-subtitulo"><?= Html::e($usuarioActual['nombre']) ?> · <?= Html::e($usuarioActual['correo']) ?> · <?= Html::e($usuarioActual['rol']) ?></p>
    </div>
</div>

<?php if (!empty($errores)): ?>
    <div class="alert alert-danger py-2">
        <ul class="mb-0">
            <?php foreach ($errores as $error): ?><li><?= Html::e($error) ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form class="panel-tarjeta" method="POST" action="<?= BASE_URL ?>/admin/perfil/cambiar" style="max-width: 560px;">
    <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
    <h2 class="panel-seccion">Cambiar mi contraseña</h2>

    <div class="mb-3">
        <label class="form-label" for="actual">Contraseña actual</label>
        <input type="password" class="form-control" id="actual" name="actual" autocomplete="current-password" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="contrasena">Contraseña nueva</label>
        <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="new-password" required>
        <div class="form-text">Mínimo 10 caracteres, combinando letras y números.</div>
    </div>
    <div class="mb-4">
        <label class="form-label" for="confirmar">Confirmar contraseña nueva</label>
        <input type="password" class="form-control" id="confirmar" name="confirmar" autocomplete="new-password" required>
    </div>

    <button type="submit" class="btn btn-panel">Guardar contraseña</button>
</form>
