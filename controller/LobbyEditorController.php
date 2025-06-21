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
            'title' => 'Panel de edición',
            'rutaLogo'=> '/LobbyEditor/show',
        ];
        if (isset($_SESSION['success'])) {
            $data['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        }

        $this->view->render('LobbyEditor', $data);
    }

    public static function logOut(){
        SessionHelper::logOut();

    }
}