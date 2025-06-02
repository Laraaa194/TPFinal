<?php

class PerfilController
{
    private $view;
    private $model;

    public function __construct($model, $view)
    {
        SessionController::requiereLogin();
        $this->model = $model;
        $this->view = $view;
    }


    public function show()
    {

        $usuarioVista = [];
        if (isset($_SESSION['usuario'])) {
            $nombreUsuarioLogueado = $_SESSION['usuario']['nombre'];
            $datosUsuario = $this->model->getUsuario($nombreUsuarioLogueado);

            if ($datosUsuario) {
                $nombreImagen = $datosUsuario['foto_perfil'];

                if ($nombreImagen == null || !file_exists('./public/imagenesUsuarios/' . $nombreImagen)) {
                    $datosUsuario['foto_perfil'] = 'default.png';
                }

                $usuarioVista['usuario'] = $datosUsuario;
            }

            $usuarioVista['pagina'] = 'perfil';
            $usuarioVista['rutaLogo'] = '/TPFinal/Lobby/show';
            $usuarioVista['mostrarLogo'] = true;


            $this->view->render("Perfil", $usuarioVista);
        }
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
