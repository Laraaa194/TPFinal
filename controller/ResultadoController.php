<?php

class ResultadoController
{
    private $view;




    public function __construct($view)
    {
        SessionHelper::requiereLogin();
        $this->view = $view;
    }

    public function show()
    {

        $timeout = isset($_GET['timeout']) && $_GET['timeout'] == 1;

        // Si timeout, forzar respuesta incorrecta
        if ($timeout) {
            $_SESSION['respuesta_correcta'] = false;
            $_SESSION['respuesta_ingresada'] = null;
            // Aquí podrías definir otros valores de sesión para que la vista sepa que fue timeout
            $mensaje = '⏰ Tiempo agotado. ¡Respuesta incorrecta!';
        } else {
            $mensaje = ''; // o algún mensaje por defecto
        }


        $preguntaEnunciado = $_SESSION['pregunta'] ?? 'Pregunta no encontrada';
        $idPregunta = $_SESSION['id_pregunta'] ?? 0;

        $respuestas = $_SESSION['respuestas'] ?? [];
        $respuestaId = $_SESSION['respuesta_ingresada'] ?? null;
        $respuestaCorrectaId = null;

        if (isset($_SESSION['respuesta_correcta_id'])) {
            $respuestaCorrectaId = $_SESSION['respuesta_correcta_id'];
        } else {

            $respuestaCorrectaId = null;
        }

        foreach ($respuestas as &$respuesta) {
            if ($respuesta['es_correcta'] == 1) {
                $respuesta['correcta'] = true;
                $respuesta['color_respuesta'] = '#178a2c';  // verde
            } else {
                $respuesta['correcta'] = false;
                $respuesta['color_respuesta'] = '#c92e2e';
            }
        }
        unset($respuesta);

//        if (!empty($_SESSION['respuesta_correcta'])) {
//            $botonRedirect = 'Partida/show';
//            $nombre_boton = 'Continuar';
//            $mensaje = '¡Respuesta Correcta! + 1 punto';
//        }
//        else {
//
//            $botonRedirect = 'Partida/terminarPartida';
//            $nombre_boton = 'Finalizar';
//            $mensaje = '¡Respuesta incorrecta!';
//        }

        $mensaje = '';
        if ($timeout) {
            $mensaje = '⏰ Tiempo agotado';
        } else if (!empty($_SESSION['respuesta_correcta'])) {
            $mensaje = '¡Respuesta Correcta! + 1 punto';
        } else {
            $mensaje = '¡Respuesta incorrecta!';
        }

        if (!empty($_SESSION['respuesta_correcta'])) {
            $botonRedirect = 'Partida/show';
            $nombre_boton = 'Continuar';
        } else {
            $botonRedirect = 'Partida/terminarPartida';
            $nombre_boton = 'Finalizar';
        }

        $data = [
            'pregunta' => $preguntaEnunciado,
            'respuestas' => $respuestas,
            'respuesta_id' => $respuestaId,
            'nombre_boton' => $nombre_boton,
            'botonRedirect' => $botonRedirect,
            'esCorrecta' => $_SESSION['respuesta_correcta'],
            'categoria' => $_SESSION['categoria_elegida']['nombre'],
            'color_pregunta' => $_SESSION['categoria_elegida']['color'],
            'color_fondo' => $_SESSION['categoria_elegida']['color_fondo'],
            'id_pregunta' => $idPregunta,
            'mensaje'=> $mensaje
        ];

        $this->unset();
        $this->view->render("Resultado", $data);
    }

    public function unset(){
        unset($_SESSION['respuesta_correcta'], $_SESSION['id_pregunta'],
            $_SESSION['respuestas'], $_SESSION['categoria_elegida'],
            $_SESSION['pregunta'], $_SESSION['pregunta']['enunciado'] );
    }
}

