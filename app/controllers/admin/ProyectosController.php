<?php

/** Panel: alta, edición y baja de proyectos, y gestión de sus fotos. */
class AdminProyectosController extends PanelController
{
    private const POR_PAGINA = 15;
    private const MAX_FOTOS_POR_ENVIO = 20;

    public function __construct()
    {
        Auth::requireLogin();
    }

    // /admin/proyectos  → listado con búsqueda, filtro por categoría y paginación
    public function index(): void
    {
        $busqueda    = $this->texto($_GET['q'] ?? '');
        $idCategoria = (int) ($_GET['categoria'] ?? 0);
        $pagina      = max(1, (int) ($_GET['pagina'] ?? 1));

        $modelo  = new Proyecto();
        $total   = $modelo->contarAdmin($busqueda, $idCategoria);
        $paginas = max(1, (int) ceil($total / self::POR_PAGINA));
        $pagina  = min($pagina, $paginas);

        $this->renderPanel('admin/proyectos/index', [
            'titulo'      => 'Proyectos',
            'seccion'     => 'proyectos',
            'filas'       => $modelo->buscarAdmin($busqueda, $idCategoria, $pagina, self::POR_PAGINA),
            'total'       => $total,
            'pagina'      => $pagina,
            'paginas'     => $paginas,
            'busqueda'    => $busqueda,
            'idCategoria' => $idCategoria,
            'categorias'  => (new Categoria())->obtenerTodas(),
        ]);
    }

    // /admin/proyectos/crear  → formulario vacío
    public function crear(): void
    {
        $vacio = ['nombre' => '', 'id_categoria' => 0, 'descripcion' => '', 'ubicacion' => '', 'fecha_proyecto' => '', 'destacado' => 0];
        $this->formulario('Nuevo proyecto', $vacio, [], '/admin/proyectos/guardar');
    }

    // POST /admin/proyectos/guardar
    public function guardar(): void
    {
        $this->requerirPost('/admin/proyectos/crear');

        [$datos, $errores] = $this->validar($_POST);
        if ($errores) {
            $this->formulario('Nuevo proyecto', $datos, $errores, '/admin/proyectos/guardar');
            return;
        }

        $id = (new Proyecto())->crear($datos);
        $this->redirigirConMensaje('/admin/proyectos/imagenes/' . $id, 'exito', 'Proyecto creado. Ahora puedes agregar sus fotos.');
    }

    // /admin/proyectos/editar/12
    public function editar($id): void
    {
        $proyecto = $this->buscar((int) $id);
        $this->formulario('Editar proyecto', $proyecto, [], '/admin/proyectos/actualizar/' . $proyecto['id_proyecto'], $proyecto['id_proyecto']);
    }

    // POST /admin/proyectos/actualizar/12
    public function actualizar($id): void
    {
        $id = (int) $id;
        $this->requerirPost('/admin/proyectos/editar/' . $id);
        $this->buscar($id);

        [$datos, $errores] = $this->validar($_POST);
        if ($errores) {
            $this->formulario('Editar proyecto', $datos, $errores, '/admin/proyectos/actualizar/' . $id, $id);
            return;
        }

        (new Proyecto())->actualizar($id, $datos);
        $this->redirigirConMensaje('/admin/proyectos', 'exito', 'Proyecto actualizado.');
    }

    // POST /admin/proyectos/eliminar/12   (solo administradores)
    public function eliminar($id): void
    {
        Auth::requireRol('admin');
        $id = (int) $id;
        $this->requerirPost('/admin/proyectos');
        $proyecto = $this->buscar($id);

        $rutas = (new Imagen())->rutasDeProyecto($id);
        (new Proyecto())->eliminar($id);
        foreach ($rutas as $ruta) {
            Upload::eliminar($ruta);
        }

        $this->redirigirConMensaje('/admin/proyectos', 'exito', 'Proyecto «' . $proyecto['nombre'] . '» eliminado.');
    }

    // ===== Fotos del proyecto =====

    // /admin/proyectos/imagenes/12
    public function imagenes($id): void
    {
        $proyecto = $this->buscar((int) $id);

        $this->renderPanel('admin/proyectos/imagenes', [
            'titulo'   => 'Fotos del proyecto',
            'seccion'  => 'proyectos',
            'proyecto' => $proyecto,
            'imagenes' => (new Imagen())->deProyecto((int) $proyecto['id_proyecto']),
        ]);
    }

    // POST /admin/proyectos/subirImagenes/12
    public function subirImagenes($id): void
    {
        $id      = (int) $id;
        $volver  = '/admin/proyectos/imagenes/' . $id;
        $this->requerirPost($volver);
        $this->buscar($id);

        $archivos = array_values(array_filter(
            Upload::lista('imagenes'),
            fn($a) => $a['error'] !== UPLOAD_ERR_NO_FILE
        ));
        if (!$archivos) {
            $this->redirigirConMensaje($volver, 'error', 'Selecciona al menos una imagen.');
        }
        if (count($archivos) > self::MAX_FOTOS_POR_ENVIO) {
            $this->redirigirConMensaje($volver, 'error', 'Sube máximo ' . self::MAX_FOTOS_POR_ENVIO . ' fotos a la vez.');
        }

        $imagenes = new Imagen();
        $orden    = $imagenes->siguienteOrden($id);
        $subidas  = 0;
        $errores  = [];

        foreach ($archivos as $archivo) {
            $resultado = Upload::guardar($archivo, 'proyectos');
            if ($resultado['ok']) {
                $imagenes->crear($id, $resultado['ruta'], null, $orden++);
                $subidas++;
            } else {
                $errores[] = $resultado['error'];
            }
        }

        if ($subidas > 0) {
            Flash::set('exito', $subidas === 1 ? 'Se agregó 1 foto.' : "Se agregaron {$subidas} fotos.");
        }
        foreach ($errores as $error) {
            Flash::set('error', $error);
        }
        $this->redirigir($volver);
    }

    // POST /admin/proyectos/portada/45   (45 = id de la imagen)
    public function portada($idImagen): void
    {
        $imagen = $this->buscarImagen((int) $idImagen);
        $volver = '/admin/proyectos/imagenes/' . $imagen['id_proyecto'];
        $this->requerirPost($volver);

        $imagenes = new Imagen();
        $imagenes->actualizarOrden((int) $imagen['id_imagen'], $imagenes->menorOrden((int) $imagen['id_proyecto']) - 1);
        $this->redirigirConMensaje($volver, 'exito', 'Foto de portada actualizada.');
    }

    // POST /admin/proyectos/descripcionImagen/45
    public function descripcionImagen($idImagen): void
    {
        $imagen = $this->buscarImagen((int) $idImagen);
        $volver = '/admin/proyectos/imagenes/' . $imagen['id_proyecto'];
        $this->requerirPost($volver);

        $alt = $this->texto($_POST['texto_alt'] ?? '');
        if (mb_strlen($alt) > 150) {
            $this->redirigirConMensaje($volver, 'error', 'La descripción de la foto admite máximo 150 caracteres.');
        }

        (new Imagen())->actualizarAlt((int) $imagen['id_imagen'], $alt !== '' ? $alt : null);
        $this->redirigirConMensaje($volver, 'exito', 'Descripción guardada.');
    }

    // POST /admin/proyectos/eliminarImagen/45
    public function eliminarImagen($idImagen): void
    {
        $imagen = $this->buscarImagen((int) $idImagen);
        $volver = '/admin/proyectos/imagenes/' . $imagen['id_proyecto'];
        $this->requerirPost($volver);

        (new Imagen())->eliminar((int) $imagen['id_imagen']);
        Upload::eliminar($imagen['ruta_archivo']);
        $this->redirigirConMensaje($volver, 'exito', 'Foto eliminada.');
    }

    // ===== Auxiliares =====

    private function buscar(int $id): array
    {
        $proyecto = (new Proyecto())->obtenerPorId($id);
        if (!$proyecto) {
            $this->redirigirConMensaje('/admin/proyectos', 'error', 'El proyecto no existe.');
        }
        return $proyecto;
    }

    private function buscarImagen(int $id): array
    {
        $imagen = (new Imagen())->obtener($id);
        if (!$imagen) {
            $this->redirigirConMensaje('/admin/proyectos', 'error', 'La foto no existe.');
        }
        return $imagen;
    }

    private function formulario(string $titulo, array $proyecto, array $errores, string $accion, ?int $id = null): void
    {
        $this->renderPanel('admin/proyectos/form', [
            'titulo'     => $titulo,
            'seccion'    => 'proyectos',
            'proyecto'   => $proyecto,
            'errores'    => $errores,
            'accion'     => $accion,
            'idProyecto' => $id,
            'categorias' => (new Categoria())->obtenerTodas(),
        ]);
    }

    // Devuelve [datos limpios, lista de errores].
    private function validar(array $post): array
    {
        $datos = [
            'nombre'         => $this->texto($post['nombre'] ?? ''),
            'id_categoria'   => (int) ($post['id_categoria'] ?? 0),
            'descripcion'    => $this->texto($post['descripcion'] ?? ''),
            'ubicacion'      => $this->texto($post['ubicacion'] ?? ''),
            'fecha_proyecto' => $this->texto($post['fecha_proyecto'] ?? ''),
            'destacado'      => !empty($post['destacado']) ? 1 : 0,
        ];

        $errores = [];
        if ($datos['nombre'] === '') {
            $errores[] = 'El nombre es obligatorio.';
        } elseif (mb_strlen($datos['nombre']) > 150) {
            $errores[] = 'El nombre admite máximo 150 caracteres.';
        }
        if (!(new Categoria())->obtenerPorId($datos['id_categoria'])) {
            $errores[] = 'Selecciona una categoría válida.';
        }
        if (mb_strlen($datos['descripcion']) > 5000) {
            $errores[] = 'La descripción admite máximo 5000 caracteres.';
        }
        if (mb_strlen($datos['ubicacion']) > 150) {
            $errores[] = 'La ubicación admite máximo 150 caracteres.';
        }
        if ($datos['fecha_proyecto'] !== '') {
            $fecha = DateTime::createFromFormat('!Y-m-d', $datos['fecha_proyecto']);
            if (!$fecha || $fecha->format('Y-m-d') !== $datos['fecha_proyecto']) {
                $errores[] = 'La fecha no es válida.';
            }
        }

        return [$datos, $errores];
    }
}
