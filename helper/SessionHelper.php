<?php

class SessionHelper
{

    public static function requiereLogin()
    {
        self::LoginStarter();
        if (!isset($_SESSION['usuario']['id'])) {
            $_SESSION['error'] = 'Debes iniciar sesión para acceder aquí.';
            RedirectHelper::redirectTo("Login/show");
        }
    }

    public static function LoginStarter(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function logOut(){
        SessionHelper::LoginStarter();
        session_unset();
        session_destroy();
        RedirectHelper::redirectTo("home/show");

    }

    public static function getUserType()
    {
        return $_SESSION['usuario']['id_tipo'] ?? null;
    }


}