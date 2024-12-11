<?php

namespace App\Models;

class Doctor {
    public $id;
    public $nombre;
    public $especialidad_id;
    public $activo;

    public function __construct($id, $nombre, $especialidad_id, $activo = true) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->especialidad_id = $especialidad_id;
        $this->activo = $activo;
    }

    public static function fromArray(array $data) {
        return new self(
            $data['id'] ?? null,
            $data['nombre'] ?? '',
            $data['especialidad_id'] ?? null,
            $data['activo'] ?? true
        );
    }
}
