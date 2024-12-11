<?php

namespace App\Repositories;

use App\Core\Database;

class PacienteRepository {
    private $db;

    // El constructor ahora usa el método 'connect' de Database
    public function __construct() {
        $this->db = Database::connect();  // Conexión a la base de datos
    }

    // Método para registrar un paciente
    public function registrar($nombre, $email, $telefono, $password) {
        $sql = "INSERT INTO pacientes (nombre, email, telefono, password) 
                VALUES (:nombre, :email, :telefono, :password)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':telefono' => $telefono,
            ':password' => password_hash($password, PASSWORD_BCRYPT)  // Contraseña encriptada
        ]);
    }

    // Método para buscar un paciente por su email
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM pacientes 
                WHERE email = :email AND activo = 1";  // Solo pacientes activos
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    // Método para listar todos los pacientes activos
    public function listar() {
        $sql = "SELECT * FROM pacientes WHERE activo = 1";  // Solo pacientes activos
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
