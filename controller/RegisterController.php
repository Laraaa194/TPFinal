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

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
            if ($_POST['accion'] === 'validarEmail' && isset($_POST['correo'])) {
                $correo = trim($_POST['correo']);
                $usuario = $this->model->getCorreoUsuario($correo);

                header('Content-Type: application/json');
                echo json_encode(['existe' => $usuario !== null]);
                exit;
            }

            if ($_POST['accion'] === 'validarNombreUsuario' && isset($_POST['nombreUsuario'])) {
                $nombreUsuario = trim($_POST['nombreUsuario']);
                $usuario = $this->model->getUsuario($nombreUsuario);

                header('Content-Type: application/json');
                echo json_encode(['existe' => $usuario !== null]);
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $anoNacimiento = $_POST["anoNacimiento"];
            $sexo = $this->model->getIdSexos($_POST["sexo"]);
            $email = $_POST["correo"];
            $password = $_POST["contrasena"];
            $repetirContrasena = $_POST["repetirContrasena"];
            $nombreUsuario = $_POST["nombreUsuario"];
            $imagen = $_FILES['imagen']['name'];
            $latitud = $_POST["lat"];
            $longitud = $_POST["lng"];
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
            $_SESSION['successRegister'] = '¡Te registraste correctamente! Verifica tu email';

            $nombreImagen = $this->agregarImagen($imagen, $nombreUsuario);


            $token=$this->model->add($nombre, $apellido, $anoNacimiento, $sexo, $email, $hash, $nombreUsuario, $nombreImagen, $latitud, $longitud, $tipo);

            $idUsuario = $this->model->getUsuario($nombreUsuario);
            EmailHelper::enviarVerificacion($nombre,$email,$token,$idUsuario['id_usuario']);


            RedirectHelper::redirectTo("Login/show");
        }
    }
    public function verificar(){
        $token=$_GET['token'];
        $idJugador = $_GET['idJugador'];

        $estaVerificado=$this->model->verificar($token,$idJugador);
        if($estaVerificado){
            $this->model->validar($idJugador);
            $data['success'] = '¡Tu cuenta fue verificada correctamente!';
        }else {
            $data['error'] = 'El enlace de verificación es inválido o ya fue usado.';
        }


        $this->view->render("Verificacion",$data);


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
        $dataRegister['title'] = 'Registro';
        $this->view->render("Register", $dataRegister);
    }




}