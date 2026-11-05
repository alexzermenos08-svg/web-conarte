<?php

/** Panel: cuentas del personal que usa el panel (solo administradores). */
class AdminUsuariosController extends PanelController
{
    private const ROLES = ['admin' => 'Administrador', 'editor' => 'Editor'];

    public function __construct()
    {
        Auth::requireRol('admin');
    }

    public function index(): void
    {
        $this->renderPanel('admin/usuarios/index', [
            'titulo'   => 'Usuarios',
            'seccion'  => 'usuarios',
            'usuarios' => (new Usuario())->todos(),
            'roles'    => self::ROLES,
        ]);
    }

    public function crear(): void
    {
        $this->formulario('Nuevo usuario', ['nombre' => '', 'correo' => '', 'rol' => 'editor', 'activo' => 1], [], null);
    }

    // POST /admin/usuarios/guardar
    public function guardar(): void
    {
        $this->requerirPost('/admin/usuarios/crear');

        [$datos, $errores] = $this->validarDatos($_POST, null);
        $nueva     = is_string($_POST['contrasena'] ?? null) ? $_POST['contrasena'] : '';
        $confirmar = is_string($_POST['confirmar'] ?? null) ? $_POST['confirmar'] : '';
        $errorClave = $this->validarClave($nueva, $confirmar, $datos['correo']);
        if ($errorClave) {
            $errores[] = $errorClave;
        }

        if ($errores) {
            $datos['activo'] = 1;
            $this->formulario('Nuevo usuario', $datos, $errores, null);
            return;
        }

        (new Usuario())->crear($datos['nombre'], $datos['correo'], password_hash($nueva, PASSWORD_DEFAULT), $datos['rol']);
        $this->redirigirConMensaje('/admin/usuarios', 'exito', 'Usuario creado. Compártele su correo y contraseña de forma segura.');
    }

    public function editar($id): void
    {
        $usuario = $this->buscar((int) $id);
        $this->formulario('Editar usuario', $usuario, [], (int) $usuario['id_usuario']);
    }

    // POST /admin/usuarios/actualizar/3
    public function actualizar($id): void
    {
        $id = (int) $id;
        $this->requerirPost('/admin/usuarios/editar/' . $id);
        $usuario = $this->buscar($id);

        [$datos, $errores] = $this->validarDatos($_POST, $id);
        $datos['activo'] = !empty($_POST['activo']) ? 1 : 0;

        $modelo   = new Usuario();
        $esYo     = $id === (int) Auth::usuario()['id'];
        $dejaDeSerAdminActivo = $usuario['rol'] === 'admin' && (int) $usuario['activo'] === 1
            && ($datos['rol'] !== 'admin' || $datos['activo'] === 0);

        if ($esYo && ($datos['rol'] !== $usuario['rol'] || $datos['activo'] === 0)) {
            $errores[] = 'No puedes cambiar tu propio rol ni desactivar tu propia cuenta.';
        } elseif ($dejaDeSerAdminActivo && $modelo->contarAdminsActivos() <= 1) {
            $errores[] = 'Debe existir al menos un administrador activo.';
        }

        if ($errores) {
            $this->formulario('Editar usuario', $datos + ['id_usuario' => $id], $errores, $id);
            return;
        }

        $modelo->actualizar($id, $datos['nombre'], $datos['correo'], $datos['rol'], (bool) $datos['activo']);
        if ($esYo) {
            Auth::refrescarUsuario(['nombre' => $datos['nombre'], 'correo' => $datos['correo']]);
        }
        $this->redirigirConMensaje('/admin/usuarios', 'exito', 'Usuario actualizado.');
    }

    // POST /admin/usuarios/contrasena/3  (el administrador asigna una contraseña nueva)
    public function contrasena($id): void
    {
        $id = (int) $id;
        $this->requerirPost('/admin/usuarios/editar/' . $id);
        $usuario = $this->buscar($id);

        $nueva     = is_string($_POST['contrasena'] ?? null) ? $_POST['contrasena'] : '';
        $confirmar = is_string($_POST['confirmar'] ?? null) ? $_POST['confirmar'] : '';
        $error = $this->validarClave($nueva, $confirmar, $usuario['correo']);
        if ($error) {
            $this->redirigirConMensaje('/admin/usuarios/editar/' . $id, 'error', $error);
        }

        (new Usuario())->cambiarContrasena($id, password_hash($nueva, PASSWORD_DEFAULT));
        $this->redirigirConMensaje('/admin/usuarios/editar/' . $id, 'exito', 'Contraseña actualizada.');
    }

    private function buscar(int $id): array
    {
        $usuario = (new Usuario())->obtener($id);
        if (!$usuario) {
            $this->redirigirConMensaje('/admin/usuarios', 'error', 'El usuario no existe.');
        }
        return $usuario;
    }

    private function formulario(string $titulo, array $usuario, array $errores, ?int $id): void
    {
        $this->renderPanel('admin/usuarios/form', [
            'titulo'    => $titulo,
            'seccion'   => 'usuarios',
            'usuario'   => $usuario,
            'errores'   => $errores,
            'idUsuario' => $id,
            'roles'     => self::ROLES,
        ]);
    }

    private function validarDatos(array $post, ?int $excluirId): array
    {
        $datos = [
            'nombre' => $this->texto($post['nombre'] ?? ''),
            'correo' => mb_strtolower($this->texto($post['correo'] ?? '')),
            'rol'    => $this->texto($post['rol'] ?? ''),
        ];

        $errores = [];
        if ($datos['nombre'] === '' || mb_strlen($datos['nombre']) > 100) {
            $errores[] = 'El nombre es obligatorio (máximo 100 caracteres).';
        }
        if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL) || mb_strlen($datos['correo']) > 150) {
            $errores[] = 'Ingresa un correo electrónico válido.';
        } elseif ((new Usuario())->existeCorreo($datos['correo'], $excluirId)) {
            $errores[] = 'Ya existe un usuario con ese correo.';
        }
        if (!isset(self::ROLES[$datos['rol']])) {
            $errores[] = 'Selecciona un rol válido.';
        }

        return [$datos, $errores];
    }

    // Devuelve el texto del error, o null si la contraseña es aceptable.
    private function validarClave(string $clave, string $confirmar, string $correo): ?string
    {
        if (mb_strlen($clave) < 10) {
            return 'La contraseña debe tener al menos 10 caracteres.';
        }
        if (!preg_match('/[A-Za-z]/', $clave) || !preg_match('/\d/', $clave)) {
            return 'La contraseña debe combinar letras y números.';
        }
        if (mb_strtolower($clave) === mb_strtolower($correo)) {
            return 'La contraseña no puede ser igual al correo.';
        }
        if ($clave !== $confirmar) {
            return 'La confirmación de la contraseña no coincide.';
        }
        return null;
    }
}
