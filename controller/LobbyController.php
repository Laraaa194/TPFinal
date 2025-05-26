<?php

class LobbyController
{
    private $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function show()
    {
        $this->requiereLogin();
        $nombreUsuarioLogueado = $_SESSION['usuario'];
        $this->view->render("Lobby", ['usuario' => $nombreUsuarioLogueado]);
    }

    private function requiereLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = 'Debes iniciar sesión para acceder al lobby.';
            header("Location: /TPFinal/Login/show");
            exit;
        }
    }
}