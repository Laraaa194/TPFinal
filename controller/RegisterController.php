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

    public function add()
    {
        $dataRegister['errors'] = [
            'nombreUsuario',
            'correo',
            'contrasena',

        ];


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $anoNacimiento = $_POST["anoNacimiento"];
            $sexo = $_POST["sexo"];
            $sexo = $this->model->getIdSexos($sexo);
            $email = $_POST["correo"];
            $password = $_POST["contrasena"];
            $repetirContrasena = $_POST["repetirContrasena"];
            $nombreUsuario = $_POST["nombreUsuario"];
            $imagen = $_FILES['imagen']['name'];
            $pais = null;
            $ciudad = null;
            $tipo = 1;


            if ($this->model->getUsuario($nombreUsuario) !== null) {
                $_SESSION['errors']['nombreUsuario'] = 'Ya existe un usuario con ese nombre';

            }

            if ($this->model->getCorreoUsuario($email) !== null) {
                $_SESSION['errors']['correo'] = 'Ya existe un usuario con ese correo';

            }

            if (!$this->validarContrasenia($password, $repetirContrasena)) {
                $_SESSION['errors']['contrasena'] = 'La contraseña no coincide';

            }

            if (!empty($_SESSION['errors'])) {
                RedirectHelper::redirectTo("Register/show");
            }
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $_SESSION['success'] = '¡Te registraste correctamente!';

            $nombreImagen = $this->agregarImagen($imagen, $nombreUsuario);

            $this->model->add($nombre, $apellido, $anoNacimiento, $sexo, $email, $hash, $nombreUsuario, $nombreImagen, $pais, $ciudad, $tipo);


            RedirectHelper::redirectTo("Login/show");
        }
    }

    public function agregarImagen($imagen, $nombreUsuario)
    {
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] === 4) {
            return null;
        }
        $error = [];
        $imagen = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $extension = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));

        $imagen_nombre = strtolower($nombreUsuario) . "." . $extension;
        $ruta_destino = './public/imagenesUsuarios/' . $imagen_nombre;

        if (!move_uploaded_file($imagen_tmp, $ruta_destino) || $imagen === null) {
            $error = "Error: No se pudo subir el archivo.";
            RedirectHelper::redirectTo("Register/show");

        }
            return $imagen_nombre;
    }


    public function validarContrasenia($password, $contraseniaRepetida)
    {
        if ($password == $contraseniaRepetida) {
            return true;
        }
    }
    public function show()
    {
        $dataRegister = [];

        if (isset($_SESSION['errors'])) {
            $dataRegister['errors'] = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }

        if (isset($_SESSION['success'])) {
            $dataRegister['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        }
        $dataRegister['pagina'] = 'register';
        $dataRegister['rutaLogo']= '/Home/show';
        $dataRegister['mostrarLogo'] = true;
        $this->view->render("Register", $dataRegister);
    }

}