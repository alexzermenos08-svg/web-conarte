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
}
