<?php

class SessionHelper
{

    public static function requiereLogin()
    {
        self::LoginStarter();
        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = 'Debes iniciar sesión para acceder aquí.';
            RedirectHelper::redirectTo("Login/show");
            exit;
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
    //cuando estén los roles, aca puede estar requiereLoginEditor, requiereLoginAdministrador?
}