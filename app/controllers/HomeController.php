<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $proyectoModel = new Proyecto();
        $categoriaModel = new Categoria();

        $this->render('home/index', [
            'proyectosDestacados' => $proyectoModel->obtenerDestacados(),
            'categorias'          => $categoriaModel->obtenerTodas(),
        ]);
    }
}
