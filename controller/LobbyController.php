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
        $data = [];
        $this->requiereLogin();
        if (isset($_SESSION['success'])) {
            $data['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        }

        $data['usuario'] = $_SESSION['usuario'];
        $data['pagina'] = 'lobby';
        $data['rutaLogo'] = '/TPFinal/Lobby/show';

        $this->view->render("Lobby", $data);
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