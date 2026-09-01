<?php

class Categoria extends Model
{
    public function obtenerTodas(): array
    {
        $stmt = $this->db->query('SELECT * FROM categorias ORDER BY nombre');
        return $stmt->fetchAll();
    }
}
