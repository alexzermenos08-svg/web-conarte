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
