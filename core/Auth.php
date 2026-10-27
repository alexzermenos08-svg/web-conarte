<?php

/**
 * Autenticación del panel de administración.
 * - Sesión con cookie HttpOnly y SameSite.
 * - Cierre de sesión por inactividad.
 * - Token CSRF para formularios.
 * - Límite de intentos fallidos de login.
 */
class Auth
{
    private const CLAVE_USUARIO   = 'usuario_panel';
    private const INACTIVIDAD_SEG = 7200;   // 2 horas
    private const MAX_FALLOS      = 5;
    private const VENTANA_SEG     = 600;    // 10 minutos

    public static function iniciarSesion(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        session_name('conarte_panel');
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'secure'   => !empty($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }

    public static function check(): bool
    {
        self::iniciarSesion();

        if (empty($_SESSION[self::CLAVE_USUARIO])) {
            return false;
        }

        $ultima = $_SESSION['ultima_actividad'] ?? 0;
        if (time() - $ultima > self::INACTIVIDAD_SEG) {
            self::logout();
            return false;
        }

        $_SESSION['ultima_actividad'] = time();
        return true;
    }

    public static function usuario(): ?array
    {
        self::iniciarSesion();
        return $_SESSION[self::CLAVE_USUARIO] ?? null;
    }

    public static function login(array $usuario): void
    {
        self::iniciarSesion();
        session_regenerate_id(true);

        $_SESSION[self::CLAVE_USUARIO] = [
            'id'     => (int) $usuario['id_usuario'],
            'nombre' => $usuario['nombre'],
            'correo' => $usuario['correo'],
            'rol'    => $usuario['rol'],
        ];
        $_SESSION['ultima_actividad'] = time();
        unset($_SESSION['fallos'], $_SESSION['csrf']);
    }

    public static function logout(): void
    {
        self::iniciarSesion();
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }

        session_destroy();
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: ' . BASE_URL . '/admin/login');
            exit;
        }
    }

    public static function requireRol(string $rol): void
    {
        self::requireLogin();
        $usuario = self::usuario();

        if (($usuario['rol'] ?? '') !== $rol) {
            http_response_code(403);
            echo 'No tienes permiso para ver esta página.';
            exit;
        }
    }

    // ===== CSRF =====

    public static function csrfToken(): string
    {
        self::iniciarSesion();

        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }

    public static function verificarCsrf(mixed $token): bool
    {
        self::iniciarSesion();

        return !empty($_SESSION['csrf'])
            && is_string($token)
            && hash_equals($_SESSION['csrf'], $token);
    }

    // ===== Límite de intentos fallidos =====

    public static function bloqueado(): bool
    {
        self::iniciarSesion();

        $ahora  = time();
        $fallos = array_filter(
            $_SESSION['fallos'] ?? [],
            fn($momento) => $ahora - $momento < self::VENTANA_SEG
        );
        $_SESSION['fallos'] = array_values($fallos);

        return count($fallos) >= self::MAX_FALLOS;
    }

    public static function registrarFallo(): void
    {
        self::iniciarSesion();
        $_SESSION['fallos'][] = time();
    }
}
