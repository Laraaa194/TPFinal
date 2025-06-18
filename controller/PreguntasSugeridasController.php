<?php

class PreguntasSugeridasController
{

    private $view;

    private $model;

    public function __construct($view, $model)
    {
        $this->view = $view;
        $this->model = $model;
    }

    public function show(){

        $preguntasSugeridas = $this->model->getPreguntasSolicitadas();

        $data= [
            'pagina' => 'preguntasSugeridas',
            'mostrarLogo'=> true,
            'rutaLogo'=> '/LobbyEditor/show',
            'preguntas' => $preguntasSugeridas

        ];

        $this->view->render("PreguntasSugeridas", $data);
    }


}