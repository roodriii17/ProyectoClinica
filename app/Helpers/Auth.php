<?php
namespace App\Helpers;

class Auth {
    public static function login($user) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
    }

    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

    public static function check() {
        session_start();
        return isset($_SESSION['user_id']);
    }

    public static function user() {
        session_start();
        return $_SESSION['user_id'] ?? null;
    }
}
