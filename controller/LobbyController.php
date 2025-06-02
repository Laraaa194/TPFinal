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
        $data['mostrarLogo'] = true;

        $this->view->render("Lobby", $data);
    }

    private function requiereLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = 'Debes iniciar sesión para acceder al lobby.';
            $this->redirectTo("Login/show");
            exit;
        }
    }

    private function redirectTo($str)
    {
        header("Location: ".BASE_URL. $str);
        exit();
    }
}