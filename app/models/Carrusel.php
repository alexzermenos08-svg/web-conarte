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

    // ===== Panel de administración =====

    public function todas(): array
    {
        $stmt = $this->db->query('SELECT * FROM carrusel_imagenes ORDER BY orden, id_carrusel');
        return $stmt->fetchAll();
    }

    public function obtener(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM carrusel_imagenes WHERE id_carrusel = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function siguienteOrden(): int
    {
        return (int) $this->db->query('SELECT COALESCE(MAX(orden), 0) + 1 FROM carrusel_imagenes')->fetchColumn();
    }

    public function crear(string $ruta, ?string $alt, int $orden): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO carrusel_imagenes (ruta_archivo, texto_alt, orden, activo) VALUES (:ruta, :alt, :orden, 1)'
        );
        $stmt->execute(['ruta' => $ruta, 'alt' => $alt, 'orden' => $orden]);
        return (int) $this->db->lastInsertId();
    }

    public function actualizar(int $id, ?string $alt, int $orden, bool $activo): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE carrusel_imagenes SET texto_alt = :alt, orden = :orden, activo = :activo WHERE id_carrusel = :id'
        );
        return $stmt->execute(['alt' => $alt, 'orden' => $orden, 'activo' => $activo ? 1 : 0, 'id' => $id]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM carrusel_imagenes WHERE id_carrusel = :id');
        return $stmt->execute(['id' => $id]);
    }
}
