<?php

/** Panel: fotos del carrusel del encabezado de la página de Inicio. */
class AdminCarruselController extends PanelController
{
    private const MAX_FOTOS_POR_ENVIO = 10;

    public function __construct()
    {
        Auth::requireLogin();
    }

    public function index(): void
    {
        $this->renderPanel('admin/carrusel/index', [
            'titulo'   => 'Carrusel',
            'seccion'  => 'carrusel',
            'imagenes' => (new Carrusel())->todas(),
        ]);
    }

    // POST /admin/carrusel/subir
    public function subir(): void
    {
        $this->requerirPost('/admin/carrusel');

        $archivos = array_values(array_filter(
            Upload::lista('imagenes'),
            fn($a) => $a['error'] !== UPLOAD_ERR_NO_FILE
        ));
        if (!$archivos) {
            $this->redirigirConMensaje('/admin/carrusel', 'error', 'Selecciona al menos una imagen.');
        }
        if (count($archivos) > self::MAX_FOTOS_POR_ENVIO) {
            $this->redirigirConMensaje('/admin/carrusel', 'error', 'Sube máximo ' . self::MAX_FOTOS_POR_ENVIO . ' fotos a la vez.');
        }

        $carrusel = new Carrusel();
        $orden    = $carrusel->siguienteOrden();
        $subidas  = 0;
        $errores  = [];

        foreach ($archivos as $archivo) {
            $resultado = Upload::guardar($archivo, 'carrusel');
            if ($resultado['ok']) {
                $carrusel->crear($resultado['ruta'], null, $orden++);
                $subidas++;
            } else {
                $errores[] = $resultado['error'];
            }
        }

        if ($subidas > 0) {
            Flash::set('exito', $subidas === 1 ? 'Se agregó 1 foto al carrusel.' : "Se agregaron {$subidas} fotos al carrusel.");
        }
        foreach ($errores as $error) {
            Flash::set('error', $error);
        }
        $this->redirigir('/admin/carrusel');
    }

    // POST /admin/carrusel/actualizar/3  (descripción, orden y si está activa)
    public function actualizar($id): void
    {
        $this->requerirPost('/admin/carrusel');
        $imagen = $this->buscar((int) $id);

        $alt = $this->texto($_POST['texto_alt'] ?? '');
        if (mb_strlen($alt) > 150) {
            $this->redirigirConMensaje('/admin/carrusel', 'error', 'La descripción admite máximo 150 caracteres.');
        }
        $orden  = (int) ($_POST['orden'] ?? 0);
        $activo = !empty($_POST['activo']);

        (new Carrusel())->actualizar((int) $imagen['id_carrusel'], $alt !== '' ? $alt : null, $orden, $activo);
        $this->redirigirConMensaje('/admin/carrusel', 'exito', 'Foto del carrusel actualizada.');
    }

    // POST /admin/carrusel/eliminar/3
    public function eliminar($id): void
    {
        $this->requerirPost('/admin/carrusel');
        $imagen = $this->buscar((int) $id);

        (new Carrusel())->eliminar((int) $imagen['id_carrusel']);
        Upload::eliminar($imagen['ruta_archivo']);
        $this->redirigirConMensaje('/admin/carrusel', 'exito', 'Foto eliminada del carrusel.');
    }

    private function buscar(int $id): array
    {
        $imagen = (new Carrusel())->obtener($id);
        if (!$imagen) {
            $this->redirigirConMensaje('/admin/carrusel', 'error', 'La foto no existe.');
        }
        return $imagen;
    }
}
