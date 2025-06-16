<?php

class crearPreguntaController
{
    private $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function show()
    {

        $data = ['pagina' => 'crearPregunta', 'rutaLogo' => '/Lobby/show', 'mostrarLogo' => true];
        $this->view->render("CrearPregunta", $data);
    }
}