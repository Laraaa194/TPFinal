<?php

class PreguntaController
{
    private $model;
    private $view;

    private $partidaPreguntaModel;

    private $preguntaUsuarioModel;

    private $usuarioModel;

    public function __construct($model, $view, $partidaPreguntaModel, $preguntaUsuarioModel, $usuarioModel)
    {
        $this->model = $model;
        $this->view = $view;
        $this->partidaPreguntaModel = $partidaPreguntaModel;
        $this->preguntaUsuarioModel = $preguntaUsuarioModel;
        $this->usuarioModel = $usuarioModel;
    }


    public function showPregunta()
    {

        $data = $this->obtenerPreguntaDesdeSesion();
        if ($data) { //si ya hay una pregunta en la sesion mostrarla
            $this->view->render("Pregunta", $data);
            return;
        }
        $nivelUsuario = $this->usuarioModel->nivelUsuario($_SESSION['usuario']['id']);

        $dataPregunta = $this->model->obtenerPreguntaNoRepetida($_SESSION['usuario']['id'], $_SESSION['categoria_elegida']['id'], $nivelUsuario);
        $this->usuarioModel->incrementarPreguntasRecibidas($_SESSION['usuario']['id']);


        $pregunta = $dataPregunta['pregunta'];
        $respuestas = $dataPregunta['respuestas'];

        $_SESSION['pregunta'] = $pregunta['enunciado'];
        $_SESSION['respuestas'] = $respuestas;
        $_SESSION['id_pregunta'] = $pregunta['id'];
        if (!isset($_SESSION['tiempo_inicio_pregunta'])) {
            $_SESSION['tiempo_inicio_pregunta'] = time();
        }
        $tiempo_inicio = $_SESSION['tiempo_inicio_pregunta'];
        $tiempo_actual = time();
        $tiempo_limite = 10;

        $tiempo_restante = max(0, $tiempo_limite - ($tiempo_actual - $tiempo_inicio));

        $respuestaCorrecta = $_SESSION['respuesta_correcta'] ?? false;

        $data = [
            'usuario' => $_SESSION['usuario'],
            'pagina' => 'pregunta',
            'mostrarLogo' => false,
            'title' => 'Pregunta',
            'categoria' => $_SESSION['categoria_elegida']['nombre'],
            'color_fondo' => $_SESSION['categoria_elegida']['color_fondo'],
            'color_pregunta' => $_SESSION['categoria_elegida']['color'],
            'pregunta' => $pregunta['enunciado'],
            'respuestas' => $respuestas,
            'id_pregunta' => $_SESSION['id_pregunta'],
            'respuesta_correcta' => $respuestaCorrecta,
            'tiempo_inicio' => $tiempo_inicio,
            'tiempo_restante' => $tiempo_restante

        ];


        $this->view->render("Pregunta", $data);
    }


    public function verificarRespuesta()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestaId = isset($_POST['respuestaId']) ? (int)$_POST['respuestaId'] : 0;
            $preguntaId = isset($_POST['preguntaId']) ? (int)$_POST['preguntaId'] : 0;

            $this->checkTiempoLimite($preguntaId);

            $esCorrecta = $this->model->esRespuestaCorrecta($preguntaId, $respuestaId);
            $_SESSION['respuesta_correcta_id'] = $this->model->getRespuestaCorrectaId($preguntaId);

            $_SESSION['respuesta_ingresada'] = $respuestaId;
            $idPartida = $_SESSION['partida']['id'];

            $this->partidaPreguntaModel->registrarTurno($idPartida, $preguntaId, $esCorrecta);
            $this->preguntaUsuarioModel->registrarPreguntaUsuario($_SESSION['usuario']['id'], $preguntaId, $respuestaId, $esCorrecta);


            if ($esCorrecta) {
                $_SESSION['partida']['puntaje_total'] = $this->model->sumarPunto($idPartida);
                $_SESSION['respuesta_correcta'] = true;
                $this->usuarioModel->incrementarPreguntasAcertadas($_SESSION['usuario']['id']);

            } else {
                $_SESSION['respuesta_correcta'] = false;


            }

            $this->model->setDificultadPregunta($preguntaId);
            RedirectHelper::redirectTo("Resultado/show");
        }
    }

    function reportarPregunta()
    {
        $idPregunta = (int)$_POST["preguntaId"];
        $_SESSION['idPregunta'] = $idPregunta;
        $pregunta = $this->model->getEnunciadoDeLaPreguntaPorId($idPregunta);
        $esCorrecta = $_POST["esCorrecta"];

        $data = [
            'id' => $idPregunta,
            'pregunta' => $pregunta['enunciado'],
            'pagina' => 'reportarPregunta',
            'esCorrecta'=> $esCorrecta,
            'mostrarLogo' => false
        ];

        $this->view->render("ReportarPregunta", $data);
    }

    function guardarReporte()
    {
        $idPregunta = $_SESSION['idPregunta'];
        $idReporteMotivo = (int)$_POST['motivo'];
        $fecha = date("Y-m-d H:i:s");
        $estaVerificada = false;
        $this->model->guardarReporte($idPregunta, $idReporteMotivo, $fecha, $estaVerificada);

        $esCorrecta=$_POST['esCorrecta'];

        if ($esCorrecta){
            RedirectHelper::redirectTo("Partida/show");
        }else{
            RedirectHelper::redirectTo("Lobby/show");
        }


    }

    private function obtenerPreguntaDesdeSesion()
    {
        if (!isset($_SESSION['pregunta'], $_SESSION['respuestas'], $_SESSION['id_pregunta'], $_SESSION['categoria_elegida'])) {
            return null;
        }

        $categoria = $_SESSION['categoria_elegida'];
        $respuestaCorrecta = $_SESSION['respuesta_correcta'] ?? false;


        return [
            'usuario' => $_SESSION['usuario'],
            'pagina' => 'pregunta',
            'mostrarLogo' => false,
            'title' => 'Pregunta',
            'categoria' => $categoria['nombre'],
            'color_fondo' => $categoria['color_fondo'],
            'color_pregunta' => $categoria['color'],
            'pregunta' => $_SESSION['pregunta'],
            'respuestas' => $_SESSION['respuestas'],
            'id_pregunta' => $_SESSION['id_pregunta'],
            'respuesta_correcta' => $respuestaCorrecta,
            'tiempo_inicio' => $_SESSION['tiempo_inicio_pregunta']
        ];
    }

    private function checkTiempoLimite(int $preguntaId)
    {
        $tiempoActual = time();
        $tiempoInicio = $_SESSION['tiempo_inicio_pregunta'] ?? 0;
        $tiempoLimite = 10;

        if (($tiempoActual - $tiempoInicio) > $tiempoLimite) {
            $_SESSION['respuesta_correcta'] = false;
            $_SESSION['respuesta_correcta_id'] = $this->model->getRespuestaCorrectaId($preguntaId);
            $_SESSION['respuesta_ingresada'] = null;
            $idPartida = $_SESSION['partida']['id'];

            $this->partidaPreguntaModel->registrarTurno($idPartida, $preguntaId, false);

            RedirectHelper::redirectTo("Resultado/show");
        }
    }




}