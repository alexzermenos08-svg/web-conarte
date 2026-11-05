<?php

class Usuario extends Model
{
    public function buscarActivoPorCorreo(string $correo): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id_usuario, nombre, correo, contrasena, rol
             FROM usuarios
             WHERE correo = :correo AND activo = 1
             LIMIT 1'
        );
        $stmt->execute(['correo' => $correo]);

        $fila = $stmt->fetch();
        return $fila ?: null;
    }

    // ===== Administración de cuentas =====

    public function todos(): array
    {
        return $this->db->query(
            'SELECT id_usuario, nombre, correo, rol, activo, creado_en FROM usuarios ORDER BY activo DESC, nombre'
        )->fetchAll();
    }

    public function obtener(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id_usuario, nombre, correo, contrasena, rol, activo FROM usuarios WHERE id_usuario = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function existeCorreo(string $correo, ?int $excluirId = null): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM usuarios WHERE correo = :correo AND id_usuario <> :id');
        $stmt->execute(['correo' => $correo, 'id' => $excluirId ?? 0]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function crear(string $nombre, string $correo, string $hash, string $rol): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO usuarios (nombre, correo, contrasena, rol, activo) VALUES (:nombre, :correo, :hash, :rol, 1)'
        );
        $stmt->execute(['nombre' => $nombre, 'correo' => $correo, 'hash' => $hash, 'rol' => $rol]);
        return (int) $this->db->lastInsertId();
    }

    public function actualizar(int $id, string $nombre, string $correo, string $rol, bool $activo): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE usuarios SET nombre = :nombre, correo = :correo, rol = :rol, activo = :activo WHERE id_usuario = :id'
        );
        return $stmt->execute([
            'nombre' => $nombre, 'correo' => $correo, 'rol' => $rol, 'activo' => $activo ? 1 : 0, 'id' => $id,
        ]);
    }

    public function cambiarContrasena(int $id, string $hash): bool
    {
        $stmt = $this->db->prepare('UPDATE usuarios SET contrasena = :hash WHERE id_usuario = :id');
        return $stmt->execute(['hash' => $hash, 'id' => $id]);
    }

    public function contarAdminsActivos(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'admin' AND activo = 1")->fetchColumn();
    }
}
