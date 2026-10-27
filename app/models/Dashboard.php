<?php

class Dashboard extends Model
{
    public function resumen(): array
    {
        $fila = $this->db->query(
            'SELECT
                (SELECT COUNT(*) FROM proyectos) AS proyectos,
                (SELECT COUNT(*) FROM categorias) AS categorias,
                (SELECT COUNT(*) FROM contactos WHERE atendido = 0) AS mensajes_pendientes'
        )->fetch();

        // La tabla del carrusel puede no existir todavía; en ese caso se muestra 0.
        try {
            $fila['carrusel'] = (int) $this->db
                ->query('SELECT COUNT(*) FROM carrusel_imagenes WHERE activo = 1')
                ->fetchColumn();
        } catch (PDOException $e) {
            $fila['carrusel'] = 0;
        }

        return $fila;
    }

    public function ultimosContactos(int $limite = 5): array
    {
        $stmt = $this->db->prepare(
            'SELECT id_contacto, nombre, correo, mensaje, atendido, creado_en
             FROM contactos
             ORDER BY creado_en DESC, id_contacto DESC
             LIMIT :limite'
        );
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
