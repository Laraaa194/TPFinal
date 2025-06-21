<?php

class RankingController
{

    private $view;
    private $partidaModel;

    public function __construct($view, $partidaModel){
        $this->view = $view;
        $this->partidaModel = $partidaModel;
    }

    public function show() {
        $tipo = $_POST['tipo'] ?? 'mejor_partida';

        $ranking = $this->getRanking($tipo);
        $rankingConMedallas = $this->agregarMedallas($ranking);
        $misPartidas = $this->partidaModel->getPartidasOrdenadasPorFecha($_SESSION['usuario']['id']);

        $this->view->render("Ranking", [
            'usuario' => $_SESSION['usuario'],
            'ranking' => $rankingConMedallas,
            'mis_partidas' => $misPartidas,
            'tipo_mejor_partida' => $tipo === 'mejor_partida',
            'tipo_acumulado' => $tipo === 'acumulado',
            'mostrarLogo' => true,
            'pagina' => 'ranking',
            'rutaLogo' => '/Lobby/show',
            'title' => 'Ranking'
        ]);
    }

    private function getRanking(string $tipo): array {
        if ($tipo === 'acumulado') {
            return $this->partidaModel->getRankingPorPuntajeAcumulado();
        } else {
            return $this->partidaModel->getRankingPorMejorPartida();
        }
    }

    private function agregarMedallas(array $ranking): array {
        $medallas = ['🥇', '🥈', '🥉'];
        foreach ($ranking as $i => &$usuario) {
            $usuario['isTop3'] = $i < 3;
            $usuario['medalla'] = $medallas[$i] ?? '';
            $usuario['posicion'] = $i + 1;
        }
        return $ranking;
    }

}