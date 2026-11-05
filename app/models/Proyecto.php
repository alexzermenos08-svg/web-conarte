<?php

class Proyecto extends Model
{
    // Los proyectos sin fecha (p. ej. obras en proceso) se ordenan por su fecha de alta, es decir, aparecen como los más recientes.
    // Primera foto del proyecto (la de menor "orden"), usada como portada en las tarjetas.
    private const PORTADA = '(SELECT i.ruta_archivo FROM imagenes i
                              WHERE i.id_proyecto = p.id_proyecto
                              ORDER BY i.orden, i.id_imagen LIMIT 1) AS portada';

    // ===== Sitio público =====

    public function obtenerDestacados(int $limite = 6): array
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.nombre AS categoria_nombre, ' . self::PORTADA . '
             FROM proyectos p
             JOIN categorias c ON p.id_categoria = c.id_categoria
             WHERE p.destacado = 1
             ORDER BY COALESCE(p.fecha_proyecto, DATE(p.creado_en)) DESC, p.id_proyecto DESC
             LIMIT :limite'
        );
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerPorCategoria(int $idCategoria): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM proyectos WHERE id_categoria = :id ORDER BY fecha_proyecto DESC'
        );
        $stmt->execute(['id' => $idCategoria]);
        return $stmt->fetchAll();
    }

    public function obtenerTodos(): array
    {
        $stmt = $this->db->query(
            'SELECT p.*, c.nombre AS categoria_nombre, ' . self::PORTADA . '
             FROM proyectos p
             JOIN categorias c ON p.id_categoria = c.id_categoria
             ORDER BY COALESCE(p.fecha_proyecto, DATE(p.creado_en)) DESC, p.id_proyecto DESC'
        );
        return $stmt->fetchAll();
    }

    // Un proyecto con el nombre de su categoría (null si no existe).
    public function obtenerConCategoria(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.nombre AS categoria_nombre
             FROM proyectos p
             JOIN categorias c ON p.id_categoria = c.id_categoria
             WHERE p.id_proyecto = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    // ===== Panel de administración =====

    // Arma el WHERE de la búsqueda (texto en nombre/ubicación y categoría opcional).
    private function filtros(string $busqueda, int $idCategoria): array
    {
        $donde  = [];
        $params = [];

        if ($busqueda !== '') {
            $like = '%' . addcslashes($busqueda, '%_\\') . '%';
            $donde[]       = '(p.nombre LIKE :q1 OR p.ubicacion LIKE :q2)';
            $params['q1']  = $like;
            $params['q2']  = $like;
        }
        if ($idCategoria > 0) {
            $donde[]            = 'p.id_categoria = :cat';
            $params['cat']      = $idCategoria;
        }

        return [$donde ? 'WHERE ' . implode(' AND ', $donde) : '', $params];
    }

    public function contarAdmin(string $busqueda, int $idCategoria): int
    {
        [$where, $params] = $this->filtros($busqueda, $idCategoria);
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM proyectos p $where");
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function buscarAdmin(string $busqueda, int $idCategoria, int $pagina, int $porPagina): array
    {
        [$where, $params] = $this->filtros($busqueda, $idCategoria);
        $stmt = $this->db->prepare(
            "SELECT p.*, c.nombre AS categoria_nombre,
                    (SELECT COUNT(*) FROM imagenes i WHERE i.id_proyecto = p.id_proyecto) AS total_imagenes
             FROM proyectos p
             JOIN categorias c ON p.id_categoria = c.id_categoria
             $where
             ORDER BY COALESCE(p.fecha_proyecto, DATE(p.creado_en)) DESC, p.id_proyecto DESC
             LIMIT :limite OFFSET :desde"
        );
        foreach ($params as $clave => $valor) {
            $stmt->bindValue(':' . $clave, $valor, is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->bindValue(':limite', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':desde', max(0, ($pagina - 1) * $porPagina), PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM proyectos WHERE id_proyecto = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function crear(array $d): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO proyectos (id_categoria, nombre, descripcion, ubicacion, fecha_proyecto, destacado)
             VALUES (:id_categoria, :nombre, :descripcion, :ubicacion, :fecha_proyecto, :destacado)'
        );
        $stmt->execute($this->datos($d));
        return (int) $this->db->lastInsertId();
    }

    public function actualizar(int $id, array $d): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE proyectos
             SET id_categoria = :id_categoria, nombre = :nombre, descripcion = :descripcion,
                 ubicacion = :ubicacion, fecha_proyecto = :fecha_proyecto, destacado = :destacado
             WHERE id_proyecto = :id'
        );
        return $stmt->execute($this->datos($d) + ['id' => $id]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM proyectos WHERE id_proyecto = :id');
        return $stmt->execute(['id' => $id]);
    }

    private function datos(array $d): array
    {
        return [
            'id_categoria'   => (int) $d['id_categoria'],
            'nombre'         => $d['nombre'],
            'descripcion'    => $d['descripcion'] !== '' ? $d['descripcion'] : null,
            'ubicacion'      => $d['ubicacion'] !== '' ? $d['ubicacion'] : null,
            'fecha_proyecto' => $d['fecha_proyecto'] !== '' ? $d['fecha_proyecto'] : null,
            'destacado'      => !empty($d['destacado']) ? 1 : 0,
        ];
    }
}
