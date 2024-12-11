<?php

namespace App\Helpers;

use DateTime;

class Validator {
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePassword($password) {
        return strlen($password) >= 8;
    }

    public static function validatePhoneNumber($phone) {
        return preg_match('/^[0-9]{10,15}$/', $phone);
    }

    public static function validateDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}
