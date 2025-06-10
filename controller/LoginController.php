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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'] ?? '';
            $contrasenia = $_POST['contrasenia'] ?? '';

            $usuarioEncontrado = $this->model->getUsuario($usuario);

            if ($usuarioEncontrado && password_verify($contrasenia, $usuarioEncontrado['password'])) {

                $_SESSION['usuario'] = [
                    'id' => $usuarioEncontrado['id_usuario'],
                    'nombre' => $usuarioEncontrado['nombre_usuario'],
                ];
                $_SESSION['success'] = '¡Has iniciado sesión correctamente!';
                RedirectHelper::redirectTo("Lobby/show");
                exit;
            } else if(empty($usuario) || empty($contrasenia)) {
                $_SESSION['error'] = 'Completa los campos para continuar';
                RedirectHelper::redirectTo("Login/show");
                exit;
            }else{
                $_SESSION['error'] = 'Usuario o contraseña incorrectos';
                RedirectHelper::redirectTo("Login/show");
                exit;
            }
        }

    }

    public function show()
    {
        $data = [];

        if (isset($_SESSION['error'])) {
            $data['error'] = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['success'])) {
            $data['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        }

        $data['pagina'] = 'login';
        $data['rutaLogo']= '/Home/show';
        $data['mostrarLogo'] = true;

        $this->view->render("Login", $data);

    }



}