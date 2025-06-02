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
        $this->iniciarSesion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'] ?? '';
            $contrasenia = $_POST['contrasenia'] ?? '';

            $usuarioEncontrado = $this->model->getUsuario($usuario);

            if ($usuarioEncontrado && password_verify($contrasenia, $usuarioEncontrado['password'])) {

                $_SESSION['usuario'] = [
                    'id' => $usuarioEncontrado['id_usuario'],
                    'nombre' => $usuarioEncontrado['nombre_usuario'],
                    'puntaje' =>0
                ];
                $_SESSION['success'] = '¡Has iniciado sesión correctamente!';
                $this->redirectTo("Lobby/show");
                exit;
            } else if(empty($usuario) || empty($contrasenia)) {
                $_SESSION['error'] = 'Completa los campos para continuar';
                $this->redirectTo("Login/show");
                exit;
            }else{
                $_SESSION['error'] = 'Usuario o contraseña incorrectos';
                $this->redirectTo("Login/show");
                exit;
            }
        }

    }

    private function iniciarSesion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function show()
    {

        $this->iniciarSesion();


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
        $data['rutaLogo']= '/TPFinal/Home/show';
        $data['mostrarLogo'] = true;

        $this->view->render("Login", $data);

    }
    private function redirectTo($str)
    {
        header("Location: ".BASE_URL. $str);
        exit();
    }

    public function logOut(){
        session_start();
        session_unset();
        session_destroy();
        $this->redirectTo("home/show");
    }


}