<?php

class RankingController
{

    private $view;
    private $partidaModel;

    public function __construct($view, $partidaModel){
        SessionHelper::requiereLogin();
        $this->view = $view;
        $this->partidaModel = $partidaModel;
    }

    public function show(){
        $ranking = $this->partidaModel->getRanking();
        $misPartidas = $this->partidaModel->getPartidasOrdenadasPorFecha($_SESSION['usuario']['id']);

        $this->view->render("Ranking", [
            'usuario' => $_SESSION['usuario'],
            'ranking' => $ranking,
            'mis_partidas' => $misPartidas,
            'mostrarLogo' => true,
            'pagina' => 'ranking',
            'rutaLogo' => '/TPFinal/Ranking/show'
        ]);

    }

}