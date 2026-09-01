<?php

abstract class Controller
{
    /**
     * Renderiza una vista dentro del layout principal.
     * @param string $view   Ruta relativa dentro de app/views, ej: 'home/index'
     * @param array  $data   Variables que estarán disponibles en la vista
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);

        $viewPath = dirname(__DIR__) . "/app/views/{$view}.php";

        if (!file_exists($viewPath)) {
            die("Vista no encontrada: {$view}");
        }

        require dirname(__DIR__) . '/app/views/layouts/header.php';
        require $viewPath;
        require dirname(__DIR__) . '/app/views/layouts/footer.php';
    }

    /**
     * Responde en formato JSON (útil para el chatbot y endpoints AJAX).
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
