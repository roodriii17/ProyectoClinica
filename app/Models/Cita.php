<?php

namespace App\Models;

class Cita {
    public $id;
    public $paciente_id;
    public $doctor_id;
    public $fecha;
    public $hora;

    public function __construct($id, $paciente_id, $doctor_id, $fecha, $hora) {
        $this->id = $id;
        $this->paciente_id = $paciente_id;
        $this->doctor_id = $doctor_id;
        $this->fecha = $fecha;
        $this->hora = $hora;
    }

    public static function fromArray(array $data) {
        return new self(
            $data['id'] ?? null,
            $data['paciente_id'] ?? null,
            $data['doctor_id'] ?? null,
            $data['fecha'] ?? null,
            $data['hora'] ?? null
        );
    }
}
