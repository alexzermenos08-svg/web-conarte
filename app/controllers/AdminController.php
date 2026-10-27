<?php

class AdminController extends PanelController
{

    private static function hashFalso(): string
    {
        return '$2y$10$' . str_repeat('a', 22) . str_repeat('b', 31);
    }

    // /admin  → resumen del panel (requiere sesión)
    public function index(): void
    {
        Auth::requireLogin();

        $dashboard = new Dashboard();

        $this->renderPanel('admin/dashboard', [
            'titulo'           => 'Resumen',
            'seccion'          => 'resumen',
            'resumen'          => $dashboard->resumen(),
            'ultimosContactos' => $dashboard->ultimosContactos(5),
        ]);
    }

    // /admin/login  → formulario y verificación de credenciales
    public function login(): void
    {
        if (Auth::check()) {
            $this->redirigir('/admin');
        }

        $error  = null;
        $correo = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo     = is_string($_POST['correo'] ?? null) ? trim($_POST['correo']) : '';
            $contrasena = is_string($_POST['contrasena'] ?? null) ? $_POST['contrasena'] : '';

            if (!Auth::verificarCsrf($_POST['csrf'] ?? null)) {
                $error = 'La sesión expiró. Intenta de nuevo.';
            } elseif (Auth::bloqueado()) {
                $error = 'Demasiados intentos fallidos. Espera unos minutos e intenta de nuevo.';
            } else {
                $usuario = (new Usuario())->buscarActivoPorCorreo($correo);
                $hash    = $usuario['contrasena'] ?? self::hashFalso();

                if ($usuario && password_verify($contrasena, $hash)) {
                    Auth::login($usuario);
                    $this->redirigir('/admin');
                }

                Auth::registrarFallo();
                $error = 'Correo o contraseña incorrectos.';
            }
        }

        $this->renderSolo('admin/login', [
            'error'  => $error,
            'correo' => $correo,
            'csrf'   => Auth::csrfToken(),
        ]);
    }

    // /admin/logout  → solo por POST con token CSRF
    public function logout(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && Auth::verificarCsrf($_POST['csrf'] ?? null)) {
            Auth::logout();
            $this->redirigir('/admin/login');
        }

        $this->redirigir('/admin');
    }
}
