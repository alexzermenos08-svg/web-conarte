<?php

class Contacto extends Model
{
    public function guardar(array $datos): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO contactos (nombre, correo, telefono, mensaje)
             VALUES (:nombre, :correo, :telefono, :mensaje)'
        );

        return $stmt->execute([
            'nombre'   => $datos['nombre'],
            'correo'   => $datos['correo'],
            'telefono' => $datos['telefono'] ?: null,
            'mensaje'  => $datos['mensaje'],
        ]);
    }

    // ===== Panel de administración =====

    // $estado: 'todos', 'pendientes' o 'atendidos'
    private function condicion(string $estado): string
    {
        return match ($estado) {
            'pendientes' => 'WHERE atendido = 0',
            'atendidos'  => 'WHERE atendido = 1',
            default      => '',
        };
    }

    public function contar(string $estado = 'todos'): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM contactos ' . $this->condicion($estado))->fetchColumn();
    }

    public function contarPendientes(): int
    {
        return $this->contar('pendientes');
    }

    public function listar(string $estado, int $pagina, int $porPagina): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM contactos ' . $this->condicion($estado) . '
             ORDER BY creado_en DESC, id_contacto DESC
             LIMIT :limite OFFSET :desde'
        );
        $stmt->bindValue(':limite', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':desde', max(0, ($pagina - 1) * $porPagina), PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtener(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM contactos WHERE id_contacto = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function marcarAtendido(int $id, bool $atendido): bool
    {
        $stmt = $this->db->prepare('UPDATE contactos SET atendido = :a WHERE id_contacto = :id');
        return $stmt->execute(['a' => $atendido ? 1 : 0, 'id' => $id]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM contactos WHERE id_contacto = :id');
        return $stmt->execute(['id' => $id]);
    }
}
