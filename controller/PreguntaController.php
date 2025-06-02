<?php

class PreguntaController
{
    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function getPregunta($id_categoria)
    {
        return $this->model->getPregunta($id_categoria);
    }

    public function getRespuestas($id_pregunta)
    {
        return $this->model->getRespuestas($id_pregunta);
    }

    public function esRespuestaCorrecta($idPregunta, $idRespuesta)
    {
    return $this->model->esRespuestaCorrecta($idPregunta,$idRespuesta);
    }


    public function getCategoria($id_categoria)
    {
        return $this->model->getCategorias($id_categoria);
    }

    public function showPregunta()
    {
        $this->requiereLogin();
        $mapaCategorias = [
            'ciencia' => 1,
            'deporte' => 2,
            'geografia' => 3,
            'arte' => 4,
            'historia' => 5,
            'entretenimiento' => 6
        ];

        $categoriaNombre = $_SESSION['categoria_elegida'] ?? null;
        if (!isset($mapaCategorias[$categoriaNombre])) {
            $_SESSION['error'] = 'Categoría inválida.';
            $this->redirectTo("Partida/show");
            exit;
        }

        $id_categoria = $mapaCategorias[$categoriaNombre];
        $pregunta = $this->getPregunta($id_categoria);

        if (!$pregunta) {
            $_SESSION['error'] = 'No se encontraron preguntas en esta categoría.';
            $this->redirectTo("Partida/show");
            exit;
        }

        $_SESSION['pregunta'] = $pregunta['enunciado'];
        $idPregunta = $pregunta['id'];

        $respuestas = $this->getRespuestas($idPregunta);
        $_SESSION['respuestas'] = $respuestas;


        // Categorías
        $categorias = [
            'ciencia' => ['nombre' => 'Ciencia', 'color' => '#e1fae4', 'color_pregunta' => '#178a2c'],
            'deporte' => ['nombre' => 'Deporte', 'color' => '#fbded3', 'color_pregunta' => '#ff5500'],
            'geografia' => ['nombre' => 'Geografía', 'color' => '#bcc3df', 'color_pregunta' => '#2626c2'],
            'arte' => ['nombre' => 'Arte', 'color' => '#fae2e2', 'color_pregunta' => '#c92e2e'],
            'historia' => ['nombre' => 'Historia', 'color' => '#f6db91', 'color_pregunta' => '#ffcc4d'],
            'entretenimiento' => ['nombre' => 'Entretenimiento', 'color' => '#fadfec', 'color_pregunta' => '#c43e93'],
        ];


        $respuestaCorrecta = $_SESSION['respuesta_correcta'] ?? false;
        unset($_SESSION['respuesta_correcta']);

        $data = [
            'usuario' => $_SESSION['usuario'],
            'pagina' => 'pregunta',
            'mostrarLogo' => false,
            'categoria' =>$categorias[$categoriaNombre]['nombre'],
            'color_fondo' => $categorias[$categoriaNombre]['color'],
            'color_pregunta' => $categorias[$categoriaNombre]['color_pregunta'],
            'pregunta' => $pregunta['enunciado'],
            'respuestas' => $respuestas,
            'id_pregunta' => $idPregunta,
            'respuesta_correcta' => $respuestaCorrecta,
        ];

        $this->view->render("Pregunta", $data);
    }

    public function verificarRespuesta()
    {
        $this->requiereLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestaId = isset($_POST['respuestaId']) ? (int) $_POST['respuestaId'] : 0;
            $preguntaId = isset($_POST['preguntaId']) ? (int) $_POST['preguntaId'] : 0;

            $esCorrecta=$this->model->esRespuestaCorrecta($preguntaId,$respuestaId);

            if ($esCorrecta) {
                //$_SESSION['usuario']['puntaje']+=1;
                $_SESSION['respuesta_correcta'] = true;
                $this->redirectTo("Partida/show");
            } else {
                //        $_SESSION['error'] = 'Respuesta incorrecta.';
                //      header("Location: /TPFinal/Partida/partidaPerdida");
                $idUsuario=isset($_SESSION['usuario']['id']) ? (int)$_SESSION['usuario']['id'] : 0 ;
                $puntaje=isset($_SESSION['usuario']['puntaje']) ? (int)$_SESSION['usuario']['puntaje'] : 0 ;



                $_SESSION['usuario']['puntaje']=0;

                $this->partidaPerdida();
                exit();
            }
        }
    }
    public function partidaPerdida()
    {
        $this->view->render("PartidaPerdida");
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