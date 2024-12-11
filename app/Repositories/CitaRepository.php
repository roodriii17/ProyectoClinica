<?php

namespace App\Repositories;

use App\Core\Database;

class CitaRepository {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function verificarDisponibilidad($doctor_id, $fecha, $hora) {
        $sql = "SELECT * FROM citas 
                WHERE doctor_id = :doctor_id 
                AND fecha = :fecha 
                AND hora = :hora";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':doctor_id' => $doctor_id,
            ':fecha' => $fecha,
            ':hora' => $hora
        ]);
        return $stmt->rowCount() === 0;
    }

    public function crear($paciente_id, $doctor_id, $fecha, $hora) {
        $sql = "INSERT INTO citas (paciente_id, doctor_id, fecha, hora) 
                VALUES (:paciente_id, :doctor_id, :fecha, :hora)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':paciente_id' => $paciente_id,
            ':doctor_id' => $doctor_id,
            ':fecha' => $fecha,
            ':hora' => $hora
        ]);
    }

    public function listar() {
        $sql = "SELECT c.*, p.nombre AS paciente, d.nombre AS doctor 
                FROM citas c
                JOIN pacientes p ON c.paciente_id = p.id
                JOIN doctores d ON c.doctor_id = d.id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
