<?php

/** Panel: cada persona puede cambiar su propia contraseña. */
class AdminPerfilController extends PanelController
{
    public function __construct()
    {
        Auth::requireLogin();
    }

    public function index(): void
    {
        $this->renderPanel('admin/perfil/index', [
            'titulo'  => 'Mi cuenta',
            'seccion' => 'perfil',
            'errores' => [],
        ]);
    }

    // POST /admin/perfil/cambiar
    public function cambiar(): void
    {
        $this->requerirPost('/admin/perfil');

        $actual    = is_string($_POST['actual'] ?? null) ? $_POST['actual'] : '';
        $nueva     = is_string($_POST['contrasena'] ?? null) ? $_POST['contrasena'] : '';
        $confirmar = is_string($_POST['confirmar'] ?? null) ? $_POST['confirmar'] : '';

        $modelo  = new Usuario();
        $usuario = $modelo->obtener((int) Auth::usuario()['id']);

        $errores = [];
        if (!$usuario || !password_verify($actual, $usuario['contrasena'])) {
            $errores[] = 'La contraseña actual no es correcta.';
        }
        if (mb_strlen($nueva) < 10) {
            $errores[] = 'La contraseña nueva debe tener al menos 10 caracteres.';
        } elseif (!preg_match('/[A-Za-z]/', $nueva) || !preg_match('/\d/', $nueva)) {
            $errores[] = 'La contraseña nueva debe combinar letras y números.';
        } elseif ($usuario && mb_strtolower($nueva) === mb_strtolower($usuario['correo'])) {
            $errores[] = 'La contraseña no puede ser igual al correo.';
        } elseif ($nueva !== $confirmar) {
            $errores[] = 'La confirmación de la contraseña no coincide.';
        }

        if ($errores) {
            $this->renderPanel('admin/perfil/index', [
                'titulo'  => 'Mi cuenta',
                'seccion' => 'perfil',
                'errores' => $errores,
            ]);
            return;
        }

        $modelo->cambiarContrasena((int) $usuario['id_usuario'], password_hash($nueva, PASSWORD_DEFAULT));
        session_regenerate_id(true);
        $this->redirigirConMensaje('/admin/perfil', 'exito', 'Tu contraseña se actualizó.');
    }
}
