<?php

class ResultadoController
{
    private $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function show()
    {


        $preguntaEnunciado = $_SESSION['pregunta'];
        $idPregunta = $_SESSION['id_pregunta'];
        $respuestas = $_SESSION['respuestas'];
        $respuestaId = $_SESSION['respuesta_ingresada'];
        $es_correcta = $_SESSION['respuesta_correcta'];

        foreach ($respuestas as &$respuesta) {
            if ($respuesta['es_correcta'] == 1) {
                $respuesta['correcta'] = true;
                $respuesta['color_respuesta'] = '#178a2c';
            } else {
                $respuesta['correcta'] = false;
                $respuesta['color_respuesta'] = '#c92e2e';
            }
        }
        unset($respuesta);

        if ($respuestaId == null) {
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

        $_SESSION['mensaje_resultado'] = $mensaje;
        $_SESSION['nombre_boton'] = $nombre_boton;
        $_SESSION['boton_redirect'] = $botonRedirect;
        $_SESSION['resultado_mostrado'] = true;

        $data = [
            'title' => 'Resultado',
            'pregunta' => $preguntaEnunciado,
            'respuestas' => $respuestas,
            'respuesta_id' => $respuestaId,
            'nombre_boton' => $nombre_boton,
            'botonRedirect' => $botonRedirect,
            'esCorrecta' => $es_correcta,
            'categoria' => $_SESSION['categoria_elegida']['nombre'],
            'color_pregunta' => $_SESSION['categoria_elegida']['color'],
            'color_fondo' => $_SESSION['categoria_elegida']['color_fondo'],
            'id_pregunta' => $idPregunta,
            'mensaje' => $mensaje
        ];

        $this->view->render("Resultado", $data);
    }
}

