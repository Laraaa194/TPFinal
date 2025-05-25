<?php

class LoginController
{
    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }


    public function login()
    {
        $this->validarSesion();



        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'] ?? '';
            $contrasenia = $_POST['contrasenia'] ?? '';

            $usuarioEncontrado = $this->model->getUsuario($usuario);

            if ($usuarioEncontrado && password_verify($contrasenia, $usuarioEncontrado['password'])) {
                $_SESSION['usuario'] = $usuarioEncontrado['nombre'];
                $_SESSION['success'] = '¡Has iniciado sesión correctamente!';
                $this->redirectTo("/TPFinal/Home/show");
                exit;
            } else {
                $_SESSION['error'] = 'Usuario o contraseña incorrectos';
                $this->redirectTo("/TPFinal/Login/show");
                exit;
            }
        }

    }

    private function validarSesion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function show()
    {

        $this->validarSesion();


        $data = [];

        if (isset($_SESSION['error'])) {
            $data['error'] = $_SESSION['error'];
            unset($_SESSION['error']);  // Lo borramos para que no persista
        }

        if (isset($_SESSION['success'])) {
            $data['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        }

        $this->view->render("Login", $data);

    }
    private function redirectTo($str)
    {
        header("Location: " . $str);
        exit();
    }


}