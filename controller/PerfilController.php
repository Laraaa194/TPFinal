<?php

class PerfilController
{
    private $view;
    private $model;

    private $partidaModel;

    public function __construct($model, $view, $partidaModel)
    {
        $this->model = $model;
        $this->view = $view;
        $this->partidaModel =  $partidaModel;
    }


    public function show()
    {
        $data = [];
        $nombreUsuarioLogueado = $_SESSION['usuario']['nombre'];
        $datosUsuario = $this->model->getUsuarioConFoto($nombreUsuarioLogueado);

        $urlQR= 'https://localhost/perfil/verPerfil/'.$nombreUsuarioLogueado;
        $archivoQr= __DIR__ .'/../public/imagenesUsuarios/'.$nombreUsuarioLogueado.'QR.png';
        $rutaWebQR = '/public/imagenesUsuarios/' . $nombreUsuarioLogueado . 'QR.png';

        if (!file_exists($archivoQr)) {
            QRhelper::generarQRCode($urlQR, $archivoQr);
        }

            $data =[
                'pagina' => 'perfil',
                'rutaLogo' => '/Lobby/show',
                'mostrarLogo' => true,
                'usuario' => $datosUsuario,
                'title' => 'Perfil',
                'rutaQr' => $rutaWebQR,
                'mostrarUltimasPartidas'=> false
                ];

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

    public function verPerfil()
    {
        $nombreUsuario = $_GET['usuario'] ?? null;
        if (!$nombreUsuario) {
            RedirectHelper::redirectTo("Ranking/show");
        }

        $datosUsuario = $this->model->getUsuarioConFoto($nombreUsuario);

        if (!$datosUsuario) {
            RedirectHelper::redirectTo("Ranking/show");
        }

        $usuarioLogueado = $_SESSION['usuario']['nombre'];
        $esPerfilAjeno = ($usuarioLogueado !== $nombreUsuario);
        $partidas = $this->partidaModel->getPartidas($datosUsuario['id_usuario']);

        $urlQR= 'https://localhost/perfil/verPerfil/'.$nombreUsuario;
        $archivoQr= __DIR__ .'/../public/imagenesUsuarios/'.$nombreUsuario.'QR.png';
        $rutaWebQR = '/public/imagenesUsuarios/' . $nombreUsuario . 'QR.png';

        if (!file_exists($archivoQr)) {
            QRhelper::generarQRCode($urlQR, $archivoQr);
        }

        $data = [
            'pagina' => 'perfil',
            'rutaLogo' => '/Ranking/show',
            'usuario' => $datosUsuario,
            'mostrarLogo' => true,
            'title' => 'Perfil de jugador',
            'es_perfil_ajeno' => $esPerfilAjeno,
            'ultimas_partidas' => array_slice($partidas, -4),
            'rutaQr'=> $rutaWebQR,
            'mostrarUltimasPartidas'=> true
        ];

        $this->view->render("Perfil", $data);
    }

}
