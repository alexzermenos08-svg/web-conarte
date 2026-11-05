<?php $nuevo = $idUsuario === null; ?>
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

<form class="panel-tarjeta mb-3" method="POST" style="max-width: 640px;"
      action="<?= BASE_URL ?>/admin/usuarios/<?= $nuevo ? 'guardar' : 'actualizar/' . (int) $idUsuario ?>">
    <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">

    <div class="mb-3">
        <label class="form-label" for="nombre">Nombre *</label>
        <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" required value="<?= Html::e($usuario['nombre']) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label" for="correo">Correo electrónico *</label>
        <input type="email" class="form-control" id="correo" name="correo" maxlength="150" required value="<?= Html::e($usuario['correo']) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label" for="rol">Rol *</label>
        <select class="form-select" id="rol" name="rol" required>
            <?php foreach ($roles as $clave => $texto): ?>
                <option value="<?= $clave ?>" <?= $usuario['rol'] === $clave ? 'selected' : '' ?>><?= $texto ?></option>
            <?php endforeach; ?>
        </select>
        <div class="form-text">Administrador: puede además eliminar proyectos, categorías y mensajes, y gestionar usuarios.</div>
    </div>

    <?php if ($nuevo): ?>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label" for="contrasena">Contraseña *</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="new-password" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="confirmar">Confirmar contraseña *</label>
                <input type="password" class="form-control" id="confirmar" name="confirmar" autocomplete="new-password" required>
            </div>
            <div class="form-text">Mínimo 10 caracteres, combinando letras y números.</div>
        </div>
    <?php else: ?>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1" <?= !empty($usuario['activo']) ? 'checked' : '' ?>>
            <label class="form-check-label" for="activo">Cuenta activa (si se desmarca, no podrá iniciar sesión)</label>
        </div>
    <?php endif; ?>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-panel">Guardar</button>
        <a class="btn btn-panel-sec" href="<?= BASE_URL ?>/admin/usuarios">Cancelar</a>
    </div>
</form>

<?php if (!$nuevo): ?>
    <form class="panel-tarjeta" method="POST" style="max-width: 640px;" action="<?= BASE_URL ?>/admin/usuarios/contrasena/<?= (int) $idUsuario ?>">
        <input type="hidden" name="csrf" value="<?= Html::e($csrf) ?>">
        <h2 class="panel-seccion">Asignar una contraseña nueva</h2>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label" for="contrasena2">Contraseña nueva</label>
                <input type="password" class="form-control" id="contrasena2" name="contrasena" autocomplete="new-password" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="confirmar2">Confirmar contraseña</label>
                <input type="password" class="form-control" id="confirmar2" name="confirmar" autocomplete="new-password" required>
            </div>
            <div class="form-text">Mínimo 10 caracteres, combinando letras y números.</div>
        </div>
        <button type="submit" class="btn btn-panel-sec">Cambiar contraseña</button>
    </form>
<?php endif; ?>
