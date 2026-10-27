<?php

class Carrusel extends Model
{
    // Imágenes activas del encabezado, en el orden definido.
    // Si la tabla todavía no existe, devuelve vacío y el sitio muestra el encabezado sin fotos.
    public function obtenerActivas(): array
    {
        try {
            $stmt = $this->db->query(
                'SELECT * FROM carrusel_imagenes WHERE activo = 1 ORDER BY orden, id_carrusel'
            );
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}
