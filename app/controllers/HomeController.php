<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $proyectoModel = new Proyecto();
        $categoriaModel = new Categoria();
        $carruselModel = new Carrusel();

        $this->render('home/index', [
            'proyectosDestacados' => $proyectoModel->obtenerDestacados(),
            'categorias'          => $categoriaModel->obtenerTodas(),
            'carrusel'            => $carruselModel->obtenerActivas(),
        ]);
    }
}
