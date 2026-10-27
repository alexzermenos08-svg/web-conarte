<?php

/**
 * Base de los controladores del panel de administración.
 * Los módulos que se agreguen después (proyectos, categorías, etc.) heredarán de aquí.
 */
abstract class PanelController extends Controller
{
    // Renderiza una vista dentro del layout del panel (barra lateral incluida).
    protected function renderPanel(string $view, array $data = []): void
    {
        $data['usuarioActual'] = Auth::usuario();
        $data['csrf']          = Auth::csrfToken();
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
}
