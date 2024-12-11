<?php

namespace App\Repositories;

use App\Core\Database;

class DoctorRepository {
    private $db;

    public function __construct() {
        // Cambia connect() por getConnection()
        $this->db = Database::connect();
    }

    public function buscarPorEspecialidad($especialidad_id) {
        $sql = "SELECT * FROM doctores 
                WHERE especialidad_id = :especialidad_id AND activo = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':especialidad_id' => $especialidad_id]);
        return $stmt->fetchAll();
    }

    public function listar() {
        $sql = "SELECT * FROM doctores WHERE activo = 1";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
