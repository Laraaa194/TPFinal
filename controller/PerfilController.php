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
                if (empty($datosUsuario['foto_perfil'])) {
                    $datosUsuario['foto_perfil'] = 'default.png';
                }
                $usuarioVista['usuario'] = $datosUsuario;
            }
        }

        $usuarioVista['pagina'] = 'perfil';
        $usuarioVista['rutaLogo']= '/TPFinal/Lobby/show';

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
    public function cambiarFoto(){
        $this->requiereLogin();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_FILES["imagen"]["name"])){

                $this->model->borrarImagenPerfil($_SESSION['usuario']);

                $nueva_imagen = $_FILES['imagen']['name'];
                $imagen_tmp = $_FILES['imagen']['tmp_name'];
                $extension = strtolower(pathinfo($nueva_imagen, PATHINFO_EXTENSION));
                $imagen_nombre = strtolower( $_SESSION['usuario']) . "." . $extension;

                $ruta_destino = "./public/imagenesUsuarios/" . $imagen_nombre;
                if (move_uploaded_file($imagen_tmp, $ruta_destino)) {

                    // Actualizar en la base de datos con el nuevo nombre
                    $this->model->cambiarImagenPerfil($_SESSION['usuario'], $imagen_nombre);

                    header("Location: /TPFinal/Perfil/show");
                    exit();

                } else {
                    die("Error al subir la imagen.");
                }

            }
        }
    }
}