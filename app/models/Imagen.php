<?php

class Imagen extends Model
{
    public function deProyecto(int $idProyecto): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM imagenes WHERE id_proyecto = :id ORDER BY orden, id_imagen'
        );
        $stmt->execute(['id' => $idProyecto]);
        return $stmt->fetchAll();
    }

    public function obtener(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM imagenes WHERE id_imagen = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function siguienteOrden(int $idProyecto): int
    {
        $stmt = $this->db->prepare('SELECT COALESCE(MAX(orden), 0) + 1 FROM imagenes WHERE id_proyecto = :id');
        $stmt->execute(['id' => $idProyecto]);
        return (int) $stmt->fetchColumn();
    }

    public function menorOrden(int $idProyecto): int
    {
        $stmt = $this->db->prepare('SELECT COALESCE(MIN(orden), 0) FROM imagenes WHERE id_proyecto = :id');
        $stmt->execute(['id' => $idProyecto]);
        return (int) $stmt->fetchColumn();
    }

    public function crear(int $idProyecto, string $ruta, ?string $alt, int $orden): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO imagenes (id_proyecto, ruta_archivo, texto_alt, orden)
             VALUES (:id, :ruta, :alt, :orden)'
        );
        $stmt->execute(['id' => $idProyecto, 'ruta' => $ruta, 'alt' => $alt, 'orden' => $orden]);
        return (int) $this->db->lastInsertId();
    }

    public function actualizarOrden(int $id, int $orden): bool
    {
        $stmt = $this->db->prepare('UPDATE imagenes SET orden = :orden WHERE id_imagen = :id');
        return $stmt->execute(['orden' => $orden, 'id' => $id]);
    }

    public function actualizarAlt(int $id, ?string $alt): bool
    {
        $stmt = $this->db->prepare('UPDATE imagenes SET texto_alt = :alt WHERE id_imagen = :id');
        return $stmt->execute(['alt' => $alt, 'id' => $id]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM imagenes WHERE id_imagen = :id');
        return $stmt->execute(['id' => $id]);
    }

    // Rutas de todas las fotos de un proyecto (para borrarlas del disco al eliminar el proyecto).
    public function rutasDeProyecto(int $idProyecto): array
    {
        $stmt = $this->db->prepare('SELECT ruta_archivo FROM imagenes WHERE id_proyecto = :id');
        $stmt->execute(['id' => $idProyecto]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
