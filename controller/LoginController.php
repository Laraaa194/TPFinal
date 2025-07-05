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

        SessionHelper::LoginStarter();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'] ?? '';
            $contrasenia = $_POST['contrasenia'] ?? '';

            $usuarioEncontrado = $this->model->getUsuario($usuario);


            if ($usuarioEncontrado['id_tipo'] == 1 && $usuarioEncontrado['es_valido'] != 1
                && $usuarioEncontrado && password_verify($contrasenia, $usuarioEncontrado['password']) ) {
                $_SESSION['error'] = 'Tu cuenta aún no ha sido verificada. Revisá tu correo electrónico.';
                RedirectHelper::redirectTo("Login/show");
            }

            if ($usuarioEncontrado && password_verify($contrasenia, $usuarioEncontrado['password'])) {
                $_SESSION['usuario'] = [
                    'id' => $usuarioEncontrado['id_usuario'],
                    'nombre' => $usuarioEncontrado['nombre_usuario'],
                    'id_tipo' => $usuarioEncontrado['id_tipo']
                ];

                $tipo = SessionHelper::getUserType();
                $_SESSION['success'] = '¡Has iniciado sesión correctamente!';

                if($tipo == 2){
                    RedirectHelper::redirectTo("LobbyEditor/show");
                }
                if($tipo == 3){
                    RedirectHelper::redirectTo("LobbyAdmin/show");
                }
                RedirectHelper::redirectTo("Lobby/show");
            } else if(empty($usuario) || empty($contrasenia)) {
                $_SESSION['error'] = 'Completa los campos para continuar';
                RedirectHelper::redirectTo("Login/show");

            }else if (!$usuarioEncontrado || !password_verify($contrasenia, $usuarioEncontrado['password'])) {
                $_SESSION['error'] = 'Usuario o contraseña incorrectos';
                RedirectHelper::redirectTo("Login/show");

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

        if (isset($_SESSION['successRegister'])) {
            $data['successRegister'] = $_SESSION['successRegister'];
            unset($_SESSION['successRegister']);
        }
        if (isset($_SESSION['success'])) {
            $data['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        }

        $data['pagina'] = 'login';
        $data['rutaLogo']= '/Home/show';
        $data['mostrarLogo'] = true;
        $data['title'] = 'Login';

        $this->view->render("Login", $data);

    }



}