<?php

namespace App\Models;

use App\Core\Database;

class Paciente {
    public $id;
    public $nombre;
    public $email;
    public $telefono;
    public $activo;

    public static function crear($nombre, $email, $telefono, $password) {
        $db = Database::connect();
        $sql = "INSERT INTO pacientes (nombre, email, telefono, password) VALUES (:nombre, :email, :telefono, :password)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':telefono' => $telefono,
            ':password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
    }

    public static function obtenerTodos() {
        $db = Database::connect();
        $sql = "SELECT * FROM pacientes WHERE activo = 1";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public static function encontrarPorEmail($email) {
        $db = Database::connect();
        $sql = "SELECT * FROM pacientes WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }
}
