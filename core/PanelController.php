<?php

/**
 * Base de los controladores del panel de administración.
 */
abstract class PanelController extends Controller
{
    // Renderiza una vista dentro del layout del panel (barra lateral incluida).
    protected function renderPanel(string $view, array $data = []): void
    {
        $data['usuarioActual'] = Auth::usuario();
        $data['csrf']          = Auth::csrfToken();
        $data['mensajes']      = Flash::obtener();
        $data['pendientes']    = $this->mensajesPendientes();
        extract($data, EXTR_SKIP);

        $base = dirname(__DIR__) . '/app/views/';
        require $base . 'admin/layouts/header.php';
        require $base . $view . '.php';
        require $base . 'admin/layouts/footer.php';
    }

    // Renderiza una vista sin layout (por ejemplo, la pantalla de login).
    protected function renderSolo(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require dirname(__DIR__) . '/app/views/' . $view . '.php';
    }

    protected function redirigir(string $ruta): void
    {
        header('Location: ' . BASE_URL . $ruta);
        exit;
    }

    protected function redirigirConMensaje(string $ruta, string $tipo, string $mensaje): void
    {
        Flash::set($tipo, $mensaje);
        $this->redirigir($ruta);
    }

    // Exige que la petición sea POST con un token CSRF válido. Si no, vuelve al panel.
    protected function requerirPost(string $volverA = '/admin'): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir($volverA);
        }

        // Si el envío excede post_max_size, PHP descarta todo el contenido del formulario.
        if (empty($_POST) && empty($_FILES) && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
            $this->redirigirConMensaje(
                $volverA,
                'error',
                'Las imágenes superan el tamaño máximo de envío del servidor (' . ini_get('post_max_size') . '). Sube menos fotos a la vez o reduce su tamaño.'
            );
        }

        if (!Auth::verificarCsrf($_POST['csrf'] ?? null)) {
            $this->redirigirConMensaje($volverA, 'error', 'La sesión expiró. Intenta de nuevo.');
        }
    }

    // Texto limpio de un valor que viene de un formulario.
    protected function texto(mixed $valor): string
    {
        return is_string($valor) ? trim($valor) : '';
    }

    private function mensajesPendientes(): int
    {
        try {
            return (new Contacto())->contarPendientes();
        } catch (Throwable $e) {
            return 0;
        }
    }
}
