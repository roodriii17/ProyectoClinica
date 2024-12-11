<?php
class Database {
    private static $instance = null;
    private static $pdo;

    private function __construct() {
        // Evitar la creación de una nueva instancia
    }

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                self::$pdo = new PDO('mysql:host=localhost;dbname=clinica', 'root', '');
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$instance = self::$pdo;
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
                die();
            }
        }

        return self::$instance;
    }
}
?>
