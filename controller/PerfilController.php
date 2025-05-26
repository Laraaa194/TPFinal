<?php

class PerfilController
{
    private $view;
    private $model;
    public function __construct($model,$view)
    {
        $this->model = $model;
        $this->view = $view;
    }


    public function show()
    {
        $this->requiereLogin();

        $usuarioVista = [];
        if (isset($_SESSION['usuario'])) {
            $nombreUsuarioLogueado = $_SESSION['usuario'];
            $datosUsuario = $this->model->getUsuario($nombreUsuarioLogueado);
            if ($datosUsuario) {
                $usuarioVista['usuario'] = $datosUsuario;
            }
        }
        $this->view->render("Perfil", $usuarioVista);
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