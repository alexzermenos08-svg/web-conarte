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
}
