<?php

class ProyectosController extends Controller
{
    public function index(): void
    {
        $proyectoModel = new Proyecto();
        $categoriaModel = new Categoria();

        $this->render('proyectos/index', [
            'proyectos'  => $proyectoModel->obtenerTodos(),
            'categorias' => $categoriaModel->obtenerTodas(),
        ]);
    }

    // /proyectos/ver/12  → página de detalle con la galería de fotos
    public function ver($id): void
    {
        $proyecto = (new Proyecto())->obtenerConCategoria((int) $id);

        if (!$proyecto) {
            http_response_code(404);
            $this->render('errores/404');
            return;
        }

        $this->render('proyectos/ver', [
            'proyecto' => $proyecto,
            'imagenes' => (new Imagen())->deProyecto((int) $proyecto['id_proyecto']),
        ]);
    }

    // Ejemplo de endpoint que el frontend puede llamar vía fetch() para filtrar sin recargar
    public function porCategoria($idCategoria = null): void
    {
        if (!$idCategoria) {
            $this->json(['error' => 'Falta el id de categoría'], 400);
        }

        $proyectoModel = new Proyecto();
        $proyectos = $proyectoModel->obtenerPorCategoria((int) $idCategoria);

        $this->json(['proyectos' => $proyectos]);
    }
}
