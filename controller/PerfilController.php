<?php

class PerfilController
{
    private $view;
    private $model;

    public function __construct($model, $view)
    {
        SessionHelper::requiereLogin();
        $this->model = $model;
        $this->view = $view;
    }


    public function show()
    {

        $data = [];

            $nombreUsuarioLogueado = $_SESSION['usuario']['nombre'];
            $datosUsuario = $this->model->getUsuarioConFoto($nombreUsuarioLogueado);

            $data['pagina'] = 'perfil';
            $data['rutaLogo'] = '/TPFinal/Lobby/show';
            $data['mostrarLogo'] = true;
            $data['usuario'] = $datosUsuario;


            $this->view->render("Perfil", $data);
        }


    public function cambiarFoto()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_FILES["imagen"]["name"])) {

                $this->model->borrarImagenPerfil($_SESSION['usuario']);

                $nueva_imagen = $_FILES['imagen']['name'];
                $imagen_tmp = $_FILES['imagen']['tmp_name'];
                $extension = strtolower(pathinfo($nueva_imagen, PATHINFO_EXTENSION));
                $imagen_nombre = strtolower($_SESSION['usuario']) . "_" . time() . "." . $extension;

                $ruta_destino = "./public/imagenesUsuarios/" . $imagen_nombre;
                if (move_uploaded_file($imagen_tmp, $ruta_destino)) {

                    $this->model->cambiarImagenPerfil($_SESSION['usuario'], $imagen_nombre);

                    RedirectHelper::redirectTo("Perfil/show");

                } else {
                    die("Error al subir la imagen.");
                }

            }
        }
    }
}
