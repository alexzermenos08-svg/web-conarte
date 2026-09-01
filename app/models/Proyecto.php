<?php

class Proyecto extends Model
{
    public function obtenerDestacados(int $limite = 6): array
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.nombre AS categoria_nombre
             FROM proyectos p
             JOIN categorias c ON p.id_categoria = c.id_categoria
             WHERE p.destacado = 1
             ORDER BY p.fecha_proyecto DESC
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
            'SELECT p.*, c.nombre AS categoria_nombre
             FROM proyectos p
             JOIN categorias c ON p.id_categoria = c.id_categoria
             ORDER BY p.fecha_proyecto DESC'
        );
        return $stmt->fetchAll();
    }
}
