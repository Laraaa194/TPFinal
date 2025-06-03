<?php

class PreguntaController
{
    private $model;
    private $view;

    private $partidaPreguntaModel;

    public function __construct($model, $view, $partidaPreguntaModel)
    {
        SessionController::requiereLogin();
        $this->model = $model;
        $this->view = $view;
        $this->partidaPreguntaModel = $partidaPreguntaModel;
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

        // ✅ Si ya hay una pregunta cargada, usarla para evitar que cambie al recargar
        if (isset($_SESSION['pregunta'], $_SESSION['respuestas'], $_SESSION['id_pregunta'])) {
            $categoriaNombre = $_SESSION['categoria_elegida'] ?? null;
            $respuestaCorrecta = $_SESSION['respuesta_correcta'] ?? false;
            unset($_SESSION['respuesta_correcta']);

            $categorias = $this->getCategorias();

            $data = [
                'usuario' => $_SESSION['usuario'],
                'pagina' => 'pregunta',
                'mostrarLogo' => false,
                'categoria' => $categorias[$categoriaNombre]['nombre'],
                'color_fondo' => $categorias[$categoriaNombre]['color'],
                'color_pregunta' => $categorias[$categoriaNombre]['color_pregunta'],
                'pregunta' => $_SESSION['pregunta'],
                'respuestas' => $_SESSION['respuestas'],
                'id_pregunta' => $_SESSION['id_pregunta'],
                'respuesta_correcta' => $respuestaCorrecta,
            ];


            $this->view->render("Pregunta", $data);
            return;
        }

        // ✅ Si no hay pregunta previa, generarla
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
            SessionController::redirectTo("Partida/show");
            exit;
        }

        $id_categoria = $mapaCategorias[$categoriaNombre];
        $pregunta = $this->getPregunta($id_categoria);

        if (!$pregunta) {
            $_SESSION['error'] = 'No se encontraron preguntas en esta categoría.';
            SessionController::redirectTo("Partida/show");
            exit;
        }

        $idPregunta = $pregunta['id'];
        $respuestas = $this->getRespuestas($idPregunta);

        // Guardar en sesión para evitar que cambie con F5
        $_SESSION['pregunta'] = $pregunta['enunciado'];
        $_SESSION['respuestas'] = $respuestas;
        $_SESSION['id_pregunta'] = $idPregunta;

        $categorias = $this->getCategorias();

        $respuestaCorrecta = $_SESSION['respuesta_correcta'] ?? false;
        unset($_SESSION['respuesta_correcta']);

        $data = [
            'usuario' => $_SESSION['usuario'],
            'pagina' => 'pregunta',
            'mostrarLogo' => false,
            'categoria' => $categorias[$categoriaNombre]['nombre'],
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestaId = isset($_POST['respuestaId']) ? (int) $_POST['respuestaId'] : 0;
            $preguntaId = isset($_POST['preguntaId']) ? (int) $_POST['preguntaId'] : 0;


            $esCorrecta=$this->model->esRespuestaCorrecta($preguntaId,$respuestaId);

            $_SESSION['respuesta_ingresada'] = $respuestaId;
            $idPartida = $_SESSION['partida']['id_partida'];

            $this->partidaPreguntaModel->registrarTurno($idPartida,$preguntaId,$esCorrecta);


            if ($esCorrecta) {
                $_SESSION['usuario']['puntaje']+=1;
                $_SESSION['respuesta_correcta'] = true;

                unset($_SESSION['pregunta'], $_SESSION['respuestas'], $_SESSION['id_pregunta']);
                SessionController::redirectTo("Partida/show");
            } else {
                $idUsuario=isset($_SESSION['usuario']['id']) ? (int)$_SESSION['usuario']['id'] : 0 ;
                $puntaje=isset($_SESSION['usuario']['puntaje']) ? (int)$_SESSION['usuario']['puntaje'] : 0 ;

                SessionController::redirectTo("Partida/terminarPartida");

                exit();
            }
        }
    }



    public function getCategorias(): array
    {
        $categorias = [
            'ciencia' => ['nombre' => 'Ciencia', 'color' => '#e1fae4', 'color_pregunta' => '#178a2c'],
            'deporte' => ['nombre' => 'Deporte', 'color' => '#fbded3', 'color_pregunta' => '#ff5500'],
            'geografia' => ['nombre' => 'Geografía', 'color' => '#bcc3df', 'color_pregunta' => '#2626c2'],
            'arte' => ['nombre' => 'Arte', 'color' => '#fae2e2', 'color_pregunta' => '#c92e2e'],
            'historia' => ['nombre' => 'Historia', 'color' => '#f6db91', 'color_pregunta' => '#ffcc4d'],
            'entretenimiento' => ['nombre' => 'Entretenimiento', 'color' => '#fadfec', 'color_pregunta' => '#c43e93'],
        ];
        return $categorias;
    }




}