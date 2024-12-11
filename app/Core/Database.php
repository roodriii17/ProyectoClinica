<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $instance;

    private $connection;

    private function __construct() {
        // Conexión a la base de datos
        try {
            $this->connection = new PDO(
                'mysql:host=127.0.0.1;dbname=clinica;charset=utf8mb4',
                'root', 
                '', 
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    
    public static function connect() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }

  
    private function __clone() {}

    public function __wakeup() {}
}
