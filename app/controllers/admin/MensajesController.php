<?php

/** Panel: mensajes recibidos desde el formulario de contacto. */
class AdminMensajesController extends PanelController
{
    private const POR_PAGINA = 15;
    private const ESTADOS = ['todos', 'pendientes', 'atendidos'];

    public function __construct()
    {
        Auth::requireLogin();
    }

    public function index(): void
    {
        $estado = $this->texto($_GET['estado'] ?? 'todos');
        if (!in_array($estado, self::ESTADOS, true)) {
            $estado = 'todos';
        }
        $pagina = max(1, (int) ($_GET['pagina'] ?? 1));

        $modelo  = new Contacto();
        $total   = $modelo->contar($estado);
        $paginas = max(1, (int) ceil($total / self::POR_PAGINA));
        $pagina  = min($pagina, $paginas);

        $this->renderPanel('admin/mensajes/index', [
            'titulo'   => 'Mensajes',
            'seccion'  => 'mensajes',
            'filas'    => $modelo->listar($estado, $pagina, self::POR_PAGINA),
            'estado'   => $estado,
            'total'    => $total,
            'pagina'   => $pagina,
            'paginas'  => $paginas,
        ]);
    }

    // /admin/mensajes/ver/7
    public function ver($id): void
    {
        $mensaje = $this->buscar((int) $id);

        $this->renderPanel('admin/mensajes/ver', [
            'titulo'  => 'Mensaje de ' . $mensaje['nombre'],
            'seccion' => 'mensajes',
            'mensaje' => $mensaje,
        ]);
    }

    // POST /admin/mensajes/atender/7  (campo "atendido": 1 o 0)
    public function atender($id): void
    {
        $id = (int) $id;
        $this->requerirPost('/admin/mensajes/ver/' . $id);
        $this->buscar($id);

        $atendido = !empty($_POST['atendido']);
        (new Contacto())->marcarAtendido($id, $atendido);
        $this->redirigirConMensaje(
            '/admin/mensajes/ver/' . $id,
            'exito',
            $atendido ? 'Mensaje marcado como atendido.' : 'Mensaje marcado como pendiente.'
        );
    }

    // Solo administradores.
    public function eliminar($id): void
    {
        Auth::requireRol('admin');
        $id = (int) $id;
        $this->requerirPost('/admin/mensajes');
        $this->buscar($id);

        (new Contacto())->eliminar($id);
        $this->redirigirConMensaje('/admin/mensajes', 'exito', 'Mensaje eliminado.');
    }

    private function buscar(int $id): array
    {
        $mensaje = (new Contacto())->obtener($id);
        if (!$mensaje) {
            $this->redirigirConMensaje('/admin/mensajes', 'error', 'El mensaje no existe.');
        }
        return $mensaje;
    }
}
