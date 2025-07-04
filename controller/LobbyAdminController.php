<?php

class LobbyAdminController
{
    private $view;
    private $model;

    public function __construct($view, $model)
    {
        $this->view = $view;
        $this->model = $model;

    }

    public function show()
    {


        $data = [
            'pagina' => 'lobbyAdmin',
            'mostrarLogo' => true,
            'title' => 'Panel de administración',
            'rutaLogo' => '/LobbyAdmin/show',

            'datosSexoJSON' => $this->obtenerJugadoresPorSexo()['datosJSON'],

            'datosEdadJSON' => $this->obtenerJugadoresPorEdad()['datosEdadJSON'],

            'datosRespondidasJSON' => $this->obtenerCantidadRespondidas()['datosRespondidasJSON'],

            'datosPreguntasCategoriaJSON' => $this->obtenerPreguntas()['datosPreguntasCategoriaJSON'],
            'datosPreguntasDificultadJSON' => $this->obtenerPreguntas()['datosPreguntasDificultadJSON'],

            'datosPreguntasCreadasJSON' => $this->obtenerPreguntasCreadas()['datosPreguntasCreadasJSON'],

            'datosJugadoresPorPaisJSON' => $this->getJugadoresPorPais()['datosJugadoresPorPaisJSON'],

        ];
        if (isset($_SESSION['success'])) {
            $data['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        }

        $this->view->render('LobbyAdmin', $data);
    }

    public static function logOut()
    {
        SessionHelper::logOut();

    }

    public function obtenerJugadoresPorSexo(): array
    {
        $datos = $this->model->obtenerJugadoresPorSexo();
        $datosFormateados = GraficosHelper::formatearParaGraficoSexo($datos);

        return [
            'datosJSON' => $datosFormateados,
        ];

    }

    public function obtenerJugadoresPorEdad(): array
    {
        $datos = $this->model->obtenerJugadoresPorEdad();
        $datosFormateados = GraficosHelper::formatearParaGraficoEdad($datos);

        return [
            'datosEdadJSON' => $datosFormateados,
        ];
    }


    public function obtenerCantidadRespondidas(): array
    {
        $datos = $this->model->obtenerCantidadRespondidas();
        $datosFormateados = GraficosHelper::formatearParaGraficoRespuestas($datos);
        return [
            'datosRespondidasJSON' => $datosFormateados,
        ];
    }

    public function obtenerPreguntas(): array
    {
        $datos = $this->model->obtenerPreguntas();
        $datosFormateados = GraficosHelper::formatearParaGraficoPreguntas($datos);

        $data = [
            'datosPreguntasCategoriaJSON' => $datosFormateados['por_categoria'],
            'datosPreguntasDificultadJSON' => $datosFormateados['por_dificultad'],
        ];
        return $data;
    }

    public function obtenerPreguntasCreadas(): array
    {
        $datos = $this->model->obtenerPreguntasCreadas();
        $datosFormateados = GraficosHelper::formatearParaGraficoPreguntasCreadas($datos);

        return [
            'datosPreguntasCreadasJSON' => $datosFormateados
        ];

    }

    public function getPartidasPor()
    {
        $filtro = $_GET['filtro'] ?? 'mes';

        $datos = $this->model->obtenerPartidasAgrupadasPor($filtro);
        $formateado = GraficosHelper::formatearPartidasParaGrafico($datos, $filtro);

        header('Content-Type: application/json');
        echo $formateado;
    }

    public function getUsuariosNuevosPor(){
        $filtro = $_GET['filtro'] ?? 'mes';
        $datos = $this->model->obtenerJugadoresNuevosPor($filtro);

        $formateado = GraficosHelper::formatearUsuariosNuevosParaGrafico($datos, $filtro);
        header('Content-Type: application/json');
        echo $formateado;

    }

    public function  getJugadoresActivosPor(){
        $filtro = $_GET['filtro'] ?? 'mes';
        $datos = $this->model->obtenerJugadoresActivos($filtro);

        $formateado = GraficosHelper::formatearJugadoresActivosParaGrafico($datos,$filtro);
        header('Content-Type: application/json');
        echo $formateado;
    }


    public function  getJugadoresPorPais(){
        $datos = $this->model->obtenerJugadoresPorPais();

        $datosFormateados = GraficosHelper::formatearJugadoresPorPaisParaGrafico($datos);
        return [
            'datosJugadoresPorPaisJSON' => $datosFormateados
        ];
    }






}