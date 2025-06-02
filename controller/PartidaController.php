<?php

class PartidaController
{
    private $view;
    //private $preguntaController;

    private $model;
    private $preguntaModel;


    public function __construct($view, $model, $preguntaModel)
    {
        $this->view = $view;
        $this->model = $model;
        $this->preguntaModel = $preguntaModel;
    }

    public function show()
    {
        $this->requiereLogin();
        $idUsuario = $_SESSION['usuario']['id'];

        if ($this->tienePartidaActiva($idUsuario) === false) {
            $this->crearPartida();
        }


        $categorias = ['ciencia', 'deporte', 'geografia', 'arte', 'historia', 'entretenimiento'];
        $categoriaElegida = $categorias[array_rand($categorias)];
        $_SESSION['categoria_elegida'] = $categoriaElegida;


        $data = [
            'usuario' => $_SESSION['usuario'],
            'mostrarLogo' => true,
            'pagina' => 'partida',
            'rutaLogo' => '/TPFinal/Partida/show',
            'categoria_elegida' => $categoriaElegida

        ];

        $this->view->render("Partida", $data);
    }

    public function crearPartida(): bool
    {
        $this->requiereLogin();
        $idUsuario = $_SESSION['usuario']['id'];

        $this->model->addPartida($idUsuario, "activa");
        return true;
    }

    public function tienePartidaActiva($idUsuario): bool
    {
        $estadoPartida = $this->model->getEstadoPartida($idUsuario);

        return isset($estadoPartida['estado']) && $estadoPartida['estado'] === 'activa';
    }

    private function requiereLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = 'Debes iniciar sesión para acceder al lobby.';
            $this->redirectTo("Login/show");
            exit;
        }
    }


    private function redirectTo($str)
    {
        header("Location: ".BASE_URL. $str);
        exit();
    }

}

