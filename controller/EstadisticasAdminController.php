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

//    public function obtenerJugadoresPorSexo(){
//        $datos = $this->model->obtenerJugadoresPorSexo();
//        $datosFormateados = GraficosHelper::formatearParaGraficoSexo($datos);
//
//        $data= [
//            'pagina' => 'lobbyAdmin',
//            'mostrarLogo'=> true,
//            'title' => 'Panel de administración',
//            'rutaLogo'=> '/LobbyAdmin/show',
//            'datosSexo' => json_encode($datosFormateados, JSON_UNESCAPED_UNICODE)
//        ];
//        var_dump($data['datosSexo']);
//        die();
//
//        $this->view->render('LobbyAdmin', $data);
//
//    }
}