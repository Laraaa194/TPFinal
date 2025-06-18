<?php

class crearPreguntaController
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


        $data = ['pagina' => 'crearPregunta', 'rutaLogo' => '/Lobby/show', 'mostrarLogo' => true];

        if (isset($_SESSION['errors'])) {
            $data['errors'] = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }

        $this->view->render("CrearPregunta", $data);
    }

    public function registrarSolicitud(){
        $data['errors'] = [
            'categoria',
            'pregunta',
            'respuesta',
            'respuestaCorrecta',
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $categoria = (int)$_POST['selectCategoria'];
            $enunciadoPregunta = $_POST['preguntaSolicitada'];
            $respuesta1 = $_POST['respuesta1'];
            $respuesta2 = $_POST['respuesta2'];
            $respuesta3 = $_POST['respuesta3'];
            $respuesta4 = $_POST['respuesta4'];
            $respuestaCorrecta = $_POST['respuestaCorrecta'];


            $respuestas = [
                'resp1' => $_POST['respuesta1'],
                'resp2' => $_POST['respuesta2'],
                'resp3' => $_POST['respuesta3'],
                'resp4' => $_POST['respuesta4'],
            ];


            if ($this->model->getPreguntas($enunciadoPregunta)) {
                $_SESSION['errors']['pregunta'] = 'Ya existe esa pregunta.';
            }
            if($enunciadoPregunta == null){
                $_SESSION['errors']['pregunta'] = 'Tenés que escribir una pregunta.';
            }
            if ($categoria == null) {
                $_SESSION['errors']['categoria'] = 'Tenés que seleccionar una categoría.';
            }
            if ($respuesta1 == null || $respuesta2 == null || $respuesta3 == null || $respuesta4 == null) {
                $_SESSION['errors']['respuesta'] = 'Tenés que completar todas las respuestas.';
            }
            if ($respuestaCorrecta == null) {
                $_SESSION['errors']['respuestaCorrecta'] = 'Tenés que seleccionar cual es la correcta.';
            }
            if (!empty($_SESSION['errors'])) {
                RedirectHelper::redirectTo("CrearPregunta/show");
            }


            $idPregunta = $this->model->addPreguntaSolicitada($categoria, $enunciadoPregunta);

            foreach ($respuestas as $clave => $texto) {
                $esCorrecta = ($clave === $respuestaCorrecta) ? 1 : 0;
                $this->model->addRespuestaSolicitada($idPregunta, $texto, $esCorrecta);
            }

            RedirectHelper::redirectTo("Lobby/show");
        }
    }
}