<?php

/** Panel: categorías (géneros arquitectónicos) del portafolio. */
class AdminCategoriasController extends PanelController
{
    public function __construct()
    {
        Auth::requireLogin();
    }

    public function index(): void
    {
        $this->renderPanel('admin/categorias/index', [
            'titulo'     => 'Categorías',
            'seccion'    => 'categorias',
            'categorias' => (new Categoria())->listarConConteo(),
        ]);
    }

    public function crear(): void
    {
        $this->formulario('Nueva categoría', ['nombre' => '', 'descripcion' => ''], [], '/admin/categorias/guardar');
    }

    public function guardar(): void
    {
        $this->requerirPost('/admin/categorias/crear');

        [$datos, $errores] = $this->validar($_POST, null);
        if ($errores) {
            $this->formulario('Nueva categoría', $datos, $errores, '/admin/categorias/guardar');
            return;
        }

        (new Categoria())->crear($datos['nombre'], $datos['descripcion']);
        $this->redirigirConMensaje('/admin/categorias', 'exito', 'Categoría creada.');
    }

    public function editar($id): void
    {
        $categoria = $this->buscar((int) $id);
        $this->formulario('Editar categoría', $categoria, [], '/admin/categorias/actualizar/' . $categoria['id_categoria']);
    }

    public function actualizar($id): void
    {
        $id = (int) $id;
        $this->requerirPost('/admin/categorias/editar/' . $id);
        $this->buscar($id);

        [$datos, $errores] = $this->validar($_POST, $id);
        if ($errores) {
            $this->formulario('Editar categoría', $datos, $errores, '/admin/categorias/actualizar/' . $id);
            return;
        }

        (new Categoria())->actualizar($id, $datos['nombre'], $datos['descripcion']);
        $this->redirigirConMensaje('/admin/categorias', 'exito', 'Categoría actualizada.');
    }

    // Solo administradores, y solo si la categoría no tiene proyectos.
    public function eliminar($id): void
    {
        Auth::requireRol('admin');
        $id = (int) $id;
        $this->requerirPost('/admin/categorias');
        $categoria = $this->buscar($id);

        $modelo = new Categoria();
        $total  = $modelo->contarProyectos($id);
        if ($total > 0) {
            $this->redirigirConMensaje(
                '/admin/categorias',
                'error',
                "No se puede eliminar «{$categoria['nombre']}» porque tiene {$total} proyecto(s). Cámbialos de categoría primero."
            );
        }

        $modelo->eliminar($id);
        $this->redirigirConMensaje('/admin/categorias', 'exito', 'Categoría «' . $categoria['nombre'] . '» eliminada.');
    }

    private function buscar(int $id): array
    {
        $categoria = (new Categoria())->obtenerPorId($id);
        if (!$categoria) {
            $this->redirigirConMensaje('/admin/categorias', 'error', 'La categoría no existe.');
        }
        return $categoria;
    }

    private function formulario(string $titulo, array $categoria, array $errores, string $accion): void
    {
        $this->renderPanel('admin/categorias/form', [
            'titulo'    => $titulo,
            'seccion'   => 'categorias',
            'categoria' => $categoria,
            'errores'   => $errores,
            'accion'    => $accion,
        ]);
    }

    private function validar(array $post, ?int $excluirId): array
    {
        $datos = [
            'nombre'      => $this->texto($post['nombre'] ?? ''),
            'descripcion' => $this->texto($post['descripcion'] ?? ''),
        ];

        $errores = [];
        if ($datos['nombre'] === '') {
            $errores[] = 'El nombre es obligatorio.';
        } elseif (mb_strlen($datos['nombre']) > 100) {
            $errores[] = 'El nombre admite máximo 100 caracteres.';
        } elseif ((new Categoria())->existeNombre($datos['nombre'], $excluirId)) {
            $errores[] = 'Ya existe una categoría con ese nombre.';
        }
        if (mb_strlen($datos['descripcion']) > 255) {
            $errores[] = 'La descripción admite máximo 255 caracteres.';
        }

        return [$datos, $errores];
    }
}
