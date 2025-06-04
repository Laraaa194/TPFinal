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

    //cuando estén los roles, aca puede estar requiereLoginEditor, requiereLoginAdministrador?
}