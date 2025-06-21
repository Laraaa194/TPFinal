<?php

class PartidaController
{
    private $view;

    private $model;
    private $preguntaModel;

    private $partidaPreguntaModel;


    public function __construct($view, $model, $preguntaModel, $partidaPreguntaModel)
    {
        $this->view = $view;
        $this->model = $model;
        $this->preguntaModel = $preguntaModel;
        $this->partidaPreguntaModel = $partidaPreguntaModel;
    }

    public function show()
    {
        $this->unsetDatos();

        $idUsuario = $_SESSION['usuario']['id'];
        $partidaActiva = $this->model->getPartidaActiva($idUsuario);


        if ($partidaActiva === null) {
            $this->crearPartida();
            $partidaActiva = $this->model->getPartidaActiva($idUsuario);
        }

        if ($partidaActiva) {
                $_SESSION['partida'] = $partidaActiva;
        }

        $categoria =  $this->preguntaModel->getCategoriaAleatoria();
        $_SESSION['categoria_elegida'] = $categoria;



        $data = [
            'usuario' => $_SESSION['usuario'],
            'mostrarLogo' => true,
            'pagina' => 'partida',
            'rutaLogo' => '/Partida/show',
            'title' => 'Partida',
            'categoria_elegida' =>  $_SESSION['categoria_elegida'],
            'categoria_nombre' =>  $_SESSION['categoria_elegida']['nombre'],
            'partida' => $_SESSION['partida']
        ];

        $this->view->render("Partida", $data);
    }

    public function crearPartida()
    {
        $idUsuario = $_SESSION['usuario']['id'];
        $this->model->addPartida($idUsuario, true);

    }

    public function terminarPartida()
    {

        $idPartida= $this->model->getIdPartida($_SESSION['usuario']['id']);
        $idPregunta = isset($_SESSION['id_pregunta']) ? (int)$_SESSION['id_pregunta'] : 0;
        $esCorrecta =  $this->partidaPreguntaModel->esCorrecta($idPartida, $idPregunta);

        if($esCorrecta == 0 || isset($_POST['botonSalir']) ){
            $idUsuario=isset($_SESSION['usuario']['id']) ? (int)$_SESSION['usuario']['id'] : 0 ;
            $puntaje=isset($_SESSION['partida']['puntaje_total']) ? (int)$_SESSION['partida']['puntaje_total'] : 0 ;
            $this->model->terminarPartida($idUsuario, $puntaje);
            unset($_SESSION['partida']['puntaje_total']);
        }

        RedirectHelper::redirectTo("Lobby/show");
    }

    public function unsetDatos(){
        if (isset($_SESSION['resultado_mostrado']) && $_SESSION['resultado_mostrado'] === true) {
            unset(
                $_SESSION['pregunta'],
                $_SESSION['respuestas'],
                $_SESSION['id_pregunta'],
                $_SESSION['respuesta_correcta'],
                $_SESSION['respuesta_correcta_id'],
                $_SESSION['respuesta_ingresada'],
                $_SESSION['tiempo_inicio_pregunta'],
                $_SESSION['mensaje_resultado'],
                $_SESSION['nombre_boton'],
                $_SESSION['boton_redirect'],
                $_SESSION['resultado_mostrado']
            );
        }
    }

}

