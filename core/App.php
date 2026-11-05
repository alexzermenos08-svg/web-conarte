<?php

/**
 * Enrutador sencillo.
 *
 *   /                          → HomeController::index()
 *   /proyectos/ver/5           → ProyectosController::ver(5)
 *   /admin                     → AdminController::index()
 *   /admin/login               → AdminController::login()
 *   /admin/proyectos           → app/controllers/admin/ProyectosController.php (AdminProyectosController::index)
 *   /admin/proyectos/editar/5  → AdminProyectosController::editar(5)
 *
 * Solo se pueden invocar métodos públicos del controlador; los protected/private
 * (helpers internos) no son accesibles por URL.
 */
class App
{
    public function __construct()
    {
        $url   = $this->parseUrl();
        $base  = dirname(__DIR__) . '/app/controllers/';
        $archivo = null;
        $clase   = null;

        // Módulos del panel: /admin/{modulo}/...
        if (isset($url[0], $url[1]) && strtolower($url[0]) === 'admin' && preg_match('/^[a-z]+$/i', $url[1])) {
            $modulo  = ucfirst(strtolower($url[1]));
            $posible = $base . 'admin/' . $modulo . 'Controller.php';
            if (is_file($posible)) {
                $archivo = $posible;
                $clase   = 'Admin' . $modulo . 'Controller';
                $url     = array_slice($url, 2);
            }
        }

        // Controladores normales: /{controlador}/...
        if ($archivo === null) {
            if (empty($url[0])) {
                $nombre = 'Home';
            } elseif (preg_match('/^[a-z]+$/i', $url[0])) {
                $nombre = ucfirst(strtolower($url[0]));
                $url    = array_slice($url, 1);
            } else {
                $this->noEncontrado();
            }

            $posible = $base . $nombre . 'Controller.php';
            if (!is_file($posible)) {
                $this->noEncontrado();
            }
            $archivo = $posible;
            $clase   = $nombre . 'Controller';
        }

        require $archivo;
        if (!class_exists($clase)) {
            $this->noEncontrado();
        }
        $controlador = new $clase();

        // Método
        $metodo = 'index';
        if (!empty($url[0])) {
            $candidato = $url[0];
            if (!preg_match('/^[a-zA-Z]+$/', $candidato) || !is_callable([$controlador, $candidato])) {
                $this->noEncontrado();
            }
            $metodo = $candidato;
            $url    = array_slice($url, 1);
        }

        $parametros = array_values($url);
        $reflexion  = new ReflectionMethod($controlador, $metodo);
        if (count($parametros) < $reflexion->getNumberOfRequiredParameters()) {
            $this->noEncontrado();
        }

        call_user_func_array([$controlador, $metodo], $parametros);
    }

    protected function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return $url === '' ? [] : explode('/', $url);
        }
        return [];
    }

    private function noEncontrado(): void
    {
        http_response_code(404);
        $vistas = dirname(__DIR__) . '/app/views/';
        require $vistas . 'layouts/header.php';
        require $vistas . 'errores/404.php';
        require $vistas . 'layouts/footer.php';
        exit;
    }
}
