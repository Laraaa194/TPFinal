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
        // Primero, si el resultado ya fue mostrado, limpiamos la sesión
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
            if($_SESSION['nombre_boton'] == 'Continuar'){
                RedirectHelper::redirectTo('Partida/show');
            }
            return;
        }

        // Segundo, detectamos si viene por timeout
        $timeout = isset($_GET['timeout']) && $_GET['timeout'] == 1;
        if ($timeout) {
            $_SESSION['respuesta_correcta'] = false;
            $_SESSION['respuesta_ingresada'] = null;
        }

        $preguntaEnunciado = $_SESSION['pregunta'] ?? 'Pregunta no encontrada';
        $idPregunta = $_SESSION['id_pregunta'] ?? 0;
        $respuestas = $_SESSION['respuestas'] ?? [];
        $respuestaId = $_SESSION['respuesta_ingresada'] ?? null;

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

        // Mensaje según resultado
        if ($timeout) {
            $mensaje = '⏰ Tiempo agotado';
        } else if (!empty($_SESSION['respuesta_correcta'])) {
            $mensaje = '¡Respuesta Correcta! + 1 punto';
        } else {
            $mensaje = '¡Respuesta incorrecta!';
        }

        // Configuración del botón
        if (!empty($_SESSION['respuesta_correcta'])) {
            $botonRedirect = 'Partida/show';
            $nombre_boton = 'Continuar';
        } else {
            $botonRedirect = 'Partida/terminarPartida';
            $nombre_boton = 'Finalizar';
        }

        // Guardamos en sesión por si hay F5
        $_SESSION['mensaje_resultado'] = $mensaje;
        $_SESSION['nombre_boton'] = $nombre_boton;
        $_SESSION['boton_redirect'] = $botonRedirect;
        $_SESSION['resultado_mostrado'] = true;

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
            'mensaje' => $mensaje
        ];

        $this->view->render("Resultado", $data);
    }


    private function getResultadoDeSesion()
    {
        if (!isset($_SESSION['pregunta'], $_SESSION['respuestas'], $_SESSION['id_pregunta'], $_SESSION['categoria_elegida'])) {
            return null;
        }
        return [
            'pregunta' => $_SESSION['pregunta'],
            'respuestas' => $_SESSION['respuestas'],
            'respuesta_id' => $_SESSION['respuesta_ingresada'],
            'nombre_boton' => $_SESSION['nombre_boton'],
            'botonRedirect' =>  $_SESSION['boton_redirect'],
            'esCorrecta' => $_SESSION['respuesta_correcta'],
            'categoria' => $_SESSION['categoria_elegida']['nombre'],
            'color_pregunta' => $_SESSION['categoria_elegida']['color'],
            'color_fondo' => $_SESSION['categoria_elegida']['color_fondo'],
            'id_pregunta' => $_SESSION['id_pregunta'],
            'mensaje'=> $_SESSION['mensaje_resultado']
        ];
    }




}

