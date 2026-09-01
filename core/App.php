<?php

/**
 * Router muy simple: convierte una URL tipo /proyectos/gobierno
 * en ProyectosController->gobierno(), y /  en HomeController->index().
 *
 * No es un framework completo (no maneja parámetros dinámicos avanzados),
 * pero es suficiente para el alcance del sitio ConArte y fácil de explicar
 * en la defensa de la residencia.
 */
class App
{
    protected string $controllerName = 'Home';
    protected string $method = 'index';
    protected array $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // Controlador
        if (!empty($url[0])) {
            $controllerFile = dirname(__DIR__) . '/app/controllers/' . ucfirst($url[0]) . 'Controller.php';
            if (file_exists($controllerFile)) {
                $this->controllerName = ucfirst($url[0]);
                unset($url[0]);
            }
        }

        require dirname(__DIR__) . "/app/controllers/{$this->controllerName}Controller.php";
        $controllerClass = $this->controllerName . 'Controller';
        $controllerInstance = new $controllerClass();

        // Método
        if (!empty($url[1])) {
            if (method_exists($controllerInstance, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Parámetros restantes
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    protected function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
