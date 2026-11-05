<div class="panel-cabecera">
    <div>
        <h1 class="panel-titulo">Usuarios</h1>
        <p class="panel-subtitulo">Personas con acceso al panel. Los administradores pueden borrar contenido; los editores solo crear y modificar.</p>
    </div>
    <a class="btn btn-panel" href="<?= BASE_URL ?>/admin/usuarios/crear"><i class="bi bi-plus-lg"></i> Nuevo usuario</a>
</div>

<div class="panel-tarjeta">
    <div class="table-responsive">
        <table class="table panel-tabla align-middle mb-0">
            <thead>
                <tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Estado</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr class="<?= (int) $u['activo'] === 1 ? '' : 'fila-inactiva' ?>">
                        <td>
                            <a class="enlace-fila" href="<?= BASE_URL ?>/admin/usuarios/editar/<?= (int) $u['id_usuario'] ?>"><?= Html::e($u['nombre']) ?></a>
                            <?php if ((int) $u['id_usuario'] === (int) $usuarioActual['id']): ?><span class="texto-chico"> (tú)</span><?php endif; ?>
                        </td>
                        <td><?= Html::e($u['correo']) ?></td>
                        <td><?= Html::e($roles[$u['rol']] ?? $u['rol']) ?></td>
                        <td><?= (int) $u['activo'] === 1 ? '<span class="estado estado-ok">Activo</span>' : '<span class="estado estado-inactivo">Inactivo</span>' ?></td>
                        <td class="text-end">
                            <a class="btn-icono" title="Editar" href="<?= BASE_URL ?>/admin/usuarios/editar/<?= (int) $u['id_usuario'] ?>"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
