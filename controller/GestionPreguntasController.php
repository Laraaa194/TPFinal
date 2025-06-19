<?php

class GestionPreguntasController
{
    private $view;
    private $model;

    public function __construct($view, $model)
    {
        $this->view = $view;
        $this->model = $model;
    }
    public function show(){

        $preguntas = $this->model->getAllPreguntas();

        $data = [
            'pagina' => 'gestionPreguntas',
            'mostrarLogo'=> true,
            'rutaLogo'=> '/LobbyEditor/show',
            'preguntas' => $preguntas
        ];

        $this->view->render("GestionPreguntasEditor",$data);
    }

    public function buscar(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $busqueda = trim($_POST['busqueda'] ?? '');

            $preguntas = $this->model->getAllPreguntasBuscadas($busqueda);

            $data= [
                'pagina' => 'gestionPreguntas',
                'mostrarLogo'=> true,
                'rutaLogo'=> '/LobbyEditor/show',
                'preguntas' => $preguntas

            ];

            $this->view->render("GestionPreguntasEditor", $data);

        }
    }
}