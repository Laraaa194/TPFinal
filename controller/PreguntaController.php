<?php

class PreguntaController
{
    private $model;
    private $view;

    private $partidaPreguntaModel;

    public function __construct($model, $view, $partidaPreguntaModel)
    {
        SessionHelper::requiereLogin();
        $this->model = $model;
        $this->view = $view;
        $this->partidaPreguntaModel = $partidaPreguntaModel;
    }


    public function showPregunta()
    {

        $data = $this->obtenerPreguntaDesdeSesion();
        if ($data) {
            $this->view->render("Pregunta", $data);
            return;
        }

        $id_categoria = $_SESSION['categoria_elegida']['id'];
        $dataPregunta = $this->model->getPreguntaConRespuestas($id_categoria);

        if (!$dataPregunta) {
            $_SESSION['error'] = 'No se encontraron preguntas en esta categoría.';
            RedirectHelper::redirectTo("Partida/show");
        }

        $pregunta = $dataPregunta['pregunta'];
        $respuestas = $dataPregunta['respuestas'];

        // Guardar en sesión para evitar que cambie con F5
        $_SESSION['pregunta'] = $pregunta['enunciado'];
        $_SESSION['respuestas'] = $respuestas;
        $_SESSION['id_pregunta'] = $pregunta['id'];


        $respuestaCorrecta = $_SESSION['respuesta_correcta'] ?? false;
        //esto es para cuando mostremos si la rta fue correcta o no y no peuda hacer trampa

        $data = [
            'usuario' => $_SESSION['usuario'],
            'pagina' => 'pregunta',
            'mostrarLogo' => false,
            'categoria' =>  $_SESSION['categoria_elegida']['nombre'],
            'color_fondo' => $_SESSION['categoria_elegida']['color_fondo'],
            'color_pregunta' => $_SESSION['categoria_elegida']['color'],
            'pregunta' => $pregunta['enunciado'],
            'respuestas' => $respuestas,
            'id_pregunta' => $_SESSION['id_pregunta'],
            'respuesta_correcta' => $respuestaCorrecta,
        ];

        $this->view->render("Pregunta", $data);
    }


    public function verificarRespuesta()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestaId = isset($_POST['respuestaId']) ? (int) $_POST['respuestaId'] : 0;
            $preguntaId = isset($_POST['preguntaId']) ? (int) $_POST['preguntaId'] : 0;


            $esCorrecta=$this->model->esRespuestaCorrecta($preguntaId,$respuestaId);
            $_SESSION['respuesta_correcta_id'] = $this->model->getRespuestaCorrectaId($preguntaId);


            $_SESSION['respuesta_ingresada'] = $respuestaId;
            $idPartida = $_SESSION['partida']['id'];

            $this->partidaPreguntaModel->registrarTurno($idPartida,$preguntaId,$esCorrecta);


            if ($esCorrecta) {
                $_SESSION['partida']['puntaje_total'] = $this->model->sumarPunto($idPartida);
                $_SESSION['respuesta_correcta'] = true;

                RedirectHelper::redirectTo("Resultado/show");
            } else {
                $_SESSION['respuesta_correcta'] = false;
                RedirectHelper::redirectTo("Resultado/show");

            }

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
            'categoria' => $categoria['nombre'],
            'color_fondo' => $categoria['color_fondo'],
            'color_pregunta' => $categoria['color'],
            'pregunta' => $_SESSION['pregunta'],
            'respuestas' => $_SESSION['respuestas'],
            'id_pregunta' => $_SESSION['id_pregunta'],
            'respuesta_correcta' => $respuestaCorrecta,
        ];
    }


}