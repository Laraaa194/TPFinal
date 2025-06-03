<?php

class PartidaController
{
    private $view;

    private $model;
    private $preguntaModel;

    private $partidaPreguntaModel;


    public function __construct($view, $model, $preguntaModel, $partidaPreguntaModel)
    {
        SessionController::requiereLogin();
        $this->view = $view;
        $this->model = $model;
        $this->preguntaModel = $preguntaModel;
        $this->partidaPreguntaModel = $partidaPreguntaModel;
    }

    public function show()
    {
        $idUsuario = $_SESSION['usuario']['id'];


        if ($this->tienePartidaActiva($idUsuario) === false) {
            $this->crearPartida();
            $_SESSION['partida']['id_partida'] = $this->model->getIdPartida($idUsuario);
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
        SessionController::requiereLogin();
        $idUsuario = $_SESSION['usuario']['id'];
        $this->model->addPartida($idUsuario, true);
        return true;

    }


//    public function finalizarPartida()
//    {
//        $idUsuario=isset($_SESSION['usuario']['id']) ? (int)$_SESSION['usuario']['id'] : 0 ;
//        $puntaje=isset($_SESSION['usuario']['puntaje']) ? (int)$_SESSION['usuario']['puntaje'] : 0 ;
//        $_SESSION['usuario']['puntaje']=0;
//        $this->model->addPartida($idUsuario,$puntaje,"Perdida");
//        $this->partidaPerdida();
//        exit();
//    }


    public function terminarPartida()
    {

        $idPartida= $this->model->getIdPartida($_SESSION['usuario']['id']);
        $idPregunta = isset($_SESSION['id_pregunta']) ? (int)$_SESSION['id_pregunta'] : 0;

        $esCorrecta =  $this->partidaPreguntaModel->esCorrecta($idPartida, $idPregunta);

        if(!$esCorrecta  || isset($_POST['botonSalir']) ){
            $idUsuario=isset($_SESSION['usuario']['id']) ? (int)$_SESSION['usuario']['id'] : 0 ;
            $puntaje=isset($_SESSION['usuario']['puntaje']) ? (int)$_SESSION['usuario']['puntaje'] : 0 ;
            $_SESSION['usuario']['puntaje']=0;

            $this->model->terminarPartida($idUsuario, $puntaje);
            SessionController::redirectTo("Lobby/show");
            exit;
        }

    }

    public function partidaPerdida()
    {
        $this->view->render("PartidaPerdida");
    }


    public function tienePartidaActiva($idUsuario): bool
    {
        $estadoPartida = $this->model->getEstadoPartida($idUsuario);

        return isset($estadoPartida['estado']) && $estadoPartida['estado'] === 'activa';
    }


    public function getPartidas($idUsuario)
    {
        return $this->model->getPartidas($idUsuario);
    }






}

