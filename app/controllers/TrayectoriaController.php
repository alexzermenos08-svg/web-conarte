<?php

class TrayectoriaController extends Controller
{
    public function index(): void
    {
        // Contenido institucional (misión, visión, valores) es estático por definición
        // del documento de requerimientos, no se consulta de la base de datos.
        $this->render('trayectoria/index');
    }
}
