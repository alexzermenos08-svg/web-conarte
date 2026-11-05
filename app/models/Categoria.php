<?php

class Categoria extends Model
{
    public function obtenerTodas(): array
    {
        $stmt = $this->db->query('SELECT * FROM categorias ORDER BY nombre');
        return $stmt->fetchAll();
    }

    // Categorías con el número de proyectos de cada una (para el panel).
    public function listarConConteo(): array
    {
        $stmt = $this->db->query(
            'SELECT c.*, COUNT(p.id_proyecto) AS total_proyectos
             FROM categorias c
             LEFT JOIN proyectos p ON p.id_categoria = c.id_categoria
             GROUP BY c.id_categoria
             ORDER BY c.nombre'
        );
        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM categorias WHERE id_categoria = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function existeNombre(string $nombre, ?int $excluirId = null): bool
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM categorias WHERE nombre = :nombre AND id_categoria <> :id'
        );
        $stmt->execute(['nombre' => $nombre, 'id' => $excluirId ?? 0]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function contarProyectos(int $id): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM proyectos WHERE id_categoria = :id');
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn();
    }

    public function crear(string $nombre, string $descripcion): int
    {
        $stmt = $this->db->prepare('INSERT INTO categorias (nombre, descripcion) VALUES (:nombre, :descripcion)');
        $stmt->execute(['nombre' => $nombre, 'descripcion' => $descripcion !== '' ? $descripcion : null]);
        return (int) $this->db->lastInsertId();
    }

    public function actualizar(int $id, string $nombre, string $descripcion): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE categorias SET nombre = :nombre, descripcion = :descripcion WHERE id_categoria = :id'
        );
        return $stmt->execute([
            'nombre' => $nombre, 'descripcion' => $descripcion !== '' ? $descripcion : null, 'id' => $id,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM categorias WHERE id_categoria = :id');
        return $stmt->execute(['id' => $id]);
    }
}
