<?php

class HistorialModeracionController
{
    private $view;
    private $model;

    public function __construct($view, $model){
        $this->view = $view;
        $this->model = $model;
    }

    public function show(){
        $historial = $this->model->getHistorial();

        $data = [
            'pagina' => 'HistorialModeracion',
            'mostrarLogo' => true,
            'rutaLogo' => '/LobbyEditor/show',
            'title' => 'Historial de Moderaciones',
            'historial' => $historial
        ];
        $this->view->render('HistorialModeracion', $data);
    }
}