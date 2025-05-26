<?php

class RegisterController
{
    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    private function iniciarSesion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function add()
    {

        $this->iniciarSesion();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $anoNacimiento = $_POST["anoNacimiento"];
            $sexo = $_POST["sexo"];
            $email = $_POST["correo"];
            $password = $_POST["contrasena"];
            $repetirContrasena = $_POST["repetirContrasena"];
            $nombreUsuario = $_POST["nombreUsuario"];
            $imagen = $_FILES['imagen']['name'];
            $pais = null;
            $ciudad = null;



            // Verificar si el usuario ya existe

            if ($this->model->getUsuario($nombreUsuario) !== null) {
                $_SESSION['error'] = 'Ya existe un usuario con ese nombre';
                $this->redirectTo("/TPFinal/Register/show");
            }

            if ($this->model->getCorreoUsuario($email) !== null) {
                $_SESSION['error'] = 'Ya existe un usuario con ese correo';
                $this->redirectTo("/TPFinal/Register/show");

            } else if ($this->validarContrasenia($password, $repetirContrasena)) {

                $hash = password_hash($password, PASSWORD_DEFAULT);

                $_SESSION['success'] = '¡Te registraste correctamente!';
                $nombreImagen = $this->agregarImagen($imagen, $nombreUsuario);
                $this->model->add($nombre, $apellido, $anoNacimiento, $this->getIdSexo($sexo), $email, $hash, $nombreUsuario, $nombreImagen, $pais, $ciudad);
                $this->redirectTo("/TPFinal/Login/show");
            } else {
                $_SESSION['error'] = 'La contraseña no coincide';
                $this->redirectTo("/TPFinal/Register/show");
            }
        }
    }

    public function getIdSexo($sexo)
    {
        return $this->model->getIdSexos($sexo);
    }
    public function agregarImagen($imagen, $nombreUsuario)
    {
        $error = [];
        $imagen = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $extension = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));

        $imagen_nombre = strtolower($nombreUsuario) . "." . $extension;
        $ruta_destino = "./public/imagenesUsuarios/" . $imagen_nombre;

        if (!move_uploaded_file($imagen_tmp, $ruta_destino)) {
            $error = "Error: No se pudo subir el archivo.";
            $this->redirectTo("/TPFinal/Register/show");
            exit();
        }
            return $imagen_nombre;
    }


    public function validarContrasenia($password, $contraseniaRepetida){
        if($password == $contraseniaRepetida) {
            return true;
        }


    }
    public function show()
    {
        $this->iniciarSesion();
        $dataRegister = [];

        if (isset($_SESSION['error'])) {
            $dataRegister['error'] = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            $dataRegister['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        }
        $this->view->render("Register", $dataRegister);
    }

    private function redirectTo($str)
    {
        header("location:" . $str);
        exit();
    }
}