<?php

class LobbyController
{
    private $view;
    private $partidaModel;

    public function __construct($view,$partidaModel)
    {
        $this->view = $view;
        $this->partidaModel = $partidaModel;
    }

    public function show()
    {
        $data = [];
        if (isset($_SESSION['success'])) {
            $data['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        }
        $idUsuario = $_SESSION['usuario']['id'];
        $partidas = $this->partidaModel->getPartidas($idUsuario);

        $data['ultimas_partidas'] = array_slice($partidas, -4);
        $data['usuario'] = $_SESSION['usuario'];
        $data['pagina'] = 'lobby';
        $data['rutaLogo'] = '/Lobby/show';
        $data['mostrarLogo'] = true;
        $data['title'] = 'Lobby';

        $data['puntaje_total'] = $this->partidaModel->getPuntajeAcumulado($idUsuario); //Obtiene puntaje acumulado del usuario

        $this->view->render("Lobby", $data);
    }


    public static function logOut(){
       SessionHelper::logOut();

    }


}