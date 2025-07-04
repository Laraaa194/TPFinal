<?php

class EstadisticasAdminController
{
    private $view;
    private $model;

    public function __construct($view, $model)
    {
        $this->view = $view;
        $this->model = $model;

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

}