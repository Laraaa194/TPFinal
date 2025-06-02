<?php

class SessionController
{

    public static function requiereLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = 'Debes iniciar sesión para acceder al lobby.';
            self::redirectTo("Login/show");
            exit;
        }
    }

    public static function redirectTo($str)
    {
        header("Location: ".BASE_URL. $str);
        exit();
    }

}