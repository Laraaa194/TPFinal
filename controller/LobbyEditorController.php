<?php

class LobbyEditorController
{
    private $view;
    private $Model;

    public function __construct($view)
    {
        $this->view = $view;

    }

    public function show(){

        $data= [
            'pagina' => 'lobbyEditor',
            'mostrarLogo'=> true,
            'rutaLogo'=> '/LobbyEditor/show',
        ];

        $this->view->render('LobbyEditor', $data);
    }

}