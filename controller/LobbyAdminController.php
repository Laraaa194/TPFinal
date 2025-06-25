<?php

class LobbyAdminController
{
    private $view;
    private $Model;

    public function __construct($view)
    {
        $this->view = $view;

    }

    public function show(){


        $data= [
            'pagina' => 'lobbyAdmin',
            'mostrarLogo'=> true,
            'title' => 'Panel de administración',
            'rutaLogo'=> '/LobbyAdmin/show',
        ];
        if (isset($_SESSION['success'])) {
            $data['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        }

        $this->view->render('LobbyAdmin', $data);
    }

    public static function logOut(){
        SessionHelper::logOut();

    }

}