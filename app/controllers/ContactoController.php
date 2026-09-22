<?php

class ContactoController extends Controller
{
    public function index(): void
    {
        $this->render('contacto/index', ['enviado' => false, 'errores' => []]);
    }

    // Se llama vía POST cuando el visitante envía el formulario (ruta /contacto/enviar)
    public function enviar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /contacto');
            exit;
        }

        $nombre   = trim($_POST['nombre'] ?? '');
        $correo   = trim($_POST['correo'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $mensaje  = trim($_POST['mensaje'] ?? '');

        $errores = [];
        if ($nombre === '') {
            $errores[] = 'El nombre es obligatorio.';
        }
        if ($correo === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'Ingresa un correo electrónico válido.';
        }
        if ($mensaje === '') {
            $errores[] = 'El mensaje no puede estar vacío.';
        }

        if (!empty($errores)) {
            $this->render('contacto/index', ['enviado' => false, 'errores' => $errores]);
            return;
        }

        $contactoModel = new Contacto();
        $guardado = $contactoModel->guardar([
            'nombre'   => $nombre,
            'correo'   => $correo,
            'telefono' => $telefono,
            'mensaje'  => $mensaje,
        ]);

        if (!$guardado) {
            $this->render('contacto/index', [
                'enviado' => false,
                'errores' => ['Ocurrió un error al guardar tu mensaje. Intenta de nuevo.'],
            ]);
            return;
        }

        $this->render('contacto/index', ['enviado' => true, 'errores' => []]);
    }
}
