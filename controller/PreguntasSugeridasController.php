<?php

class PreguntasSugeridasController
{

    private $view;
    private $model;
    private $crearPreguntaModel;

    public function __construct($view, $model, $crearPreguntaModel)
    {
        $this->view = $view;
        $this->model = $model;
        $this->crearPreguntaModel = $crearPreguntaModel;
    }

    public function show(){

        $preguntasSugeridas = $this->model->getPreguntasSolicitadas();


        $data= [
            'pagina' => 'preguntasSugeridas',
            'mostrarLogo'=> true,
            'rutaLogo'=> '/LobbyEditor/show',
            'title' => 'Preguntas sugeridas',
            'preguntas' => $preguntasSugeridas,

        ];

        $this->view->render("PreguntasSugeridas", $data);
    }

    public function buscar(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $busqueda = trim($_POST['busqueda'] ?? '');

            $preguntas = $this->model->getPreguntasBuscadasSolicitadas($busqueda);

            $data= [
                'pagina' => 'preguntasSugeridas',
                'mostrarLogo'=> true,
                'title' => 'Preguntas sugeridas',
                'rutaLogo'=> '/LobbyEditor/show',
                'preguntas' => $preguntas

            ];

            $this->view->render("PreguntasSugeridas", $data);

        }
    }

    public function mostrarEdicion($id){

        $preguntaYRespuestas = $this->model->getPreguntaYRespuestasSolicitadas($id);
        $nombreCategoria = $this->model->getNombreCategoria($preguntaYRespuestas['pregunta']['id_categoria']);

        $data=
            [
                'pagina' => 'preguntasSugeridas',
                'mostrarLogo'=> true,
                'title' => 'Pregunta sugerida',
                'rutaLogo'=> '/PreguntasSugeridas/show',
                'pregunta' => $preguntaYRespuestas['pregunta'],
                'respuestas' => $preguntaYRespuestas['respuestas'],
                'nombreCategoria' => $nombreCategoria
            ];

        $this->view->render("EdicionPreguntaSugerida", $data);
    }

    public function aceptar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $categoria = (int)$_POST['selectCategoria'];
            $enunciadoPregunta = $_POST['enunciadoPregunta'] ?? '';
            $respuestas = $_POST['respuestas'];
            $respuestaCorrecta = $_POST['respuestaCorrecta'];
            $idPreguntaSolicitada = $_POST['idPreguntaSolicitada'];


            $idPregunta = $this->crearPreguntaModel->addPreguntaAceptada($categoria, $enunciadoPregunta);

            foreach ($respuestas as $idRespuesta => $texto) {
                $esCorrecta = ($idRespuesta == $respuestaCorrecta) ? 1 : 0;
                $this->crearPreguntaModel->addRespuestasAceptadas($idPregunta, $texto, $esCorrecta);
            }
            $this->eliminar($idPreguntaSolicitada);
        }

    }
    public function eliminar($idPregunta){
        $this->crearPreguntaModel->deleteRespuestasSolicitadas($idPregunta);
        $this->crearPreguntaModel->deletePreguntaSolicitada($idPregunta);

        RedirectHelper::redirectTo("PreguntasSugeridas/show");

    }
}