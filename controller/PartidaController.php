<?php

class PartidaController
{
    private $view;


    public function __construct($view){
        $this->view = $view;
    }

    public function show() {
        $this->requiereLogin();

        $categorias = ['ciencia', 'deporte', 'geografia', 'arte', 'historia', 'entretenimiento'];
        $categoriaElegida = $categorias[array_rand($categorias)];
        $_SESSION['categoria_elegida'] = $categoriaElegida;

        $data = [
            'usuario' => $_SESSION['usuario'],
            'pagina' => 'partida',
            'rutaLogo' => '/TPFinal/Partida/show',
            'categoria_elegida' => $categoriaElegida
        ];

        $this->view->render("Partida", $data);
    }

    private function requiereLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = 'Debes iniciar sesión para acceder al lobby.';
            header("Location: /TPFinal/Login/show");
            exit;
        }
    }
    public function pregunta() {
        $this->requiereLogin();

        $categorias = [
            'ciencia' => ['nombre' => 'Ciencia', 'color' => '#e1fae4', 'color_pregunta' => '#178a2c'],
            'deporte' => ['nombre' => 'Deportes', 'color' => '#fbded3', 'color_pregunta' => '#ff5500'],
            'geografia' => ['nombre' => 'Geografía', 'color' => '#bcc3df', 'color_pregunta' => '#2626c2'],
            'arte' => ['nombre' => 'Arte', 'color' => '#fae2e2', 'color_pregunta' => '#c92e2e'],
            'historia' => ['nombre' => 'Historia', 'color' => '#f6db91', 'color_pregunta' => '#ffcc4d'],
            'entretenimiento' => ['nombre' => 'Entretenimiento', 'color' => '#fadfec', 'color_pregunta' => '#c43e93'],
        ];

        $cat = $_SESSION['categoria_elegida'] ?? null;

        if (!array_key_exists($cat, $categorias)) {
            $_SESSION['error'] = 'Categoría inválida.';
            header("Location: /TPFinal/Partida/show");
            exit;
        }

        $data = [
            'usuario' => $_SESSION['usuario'],
            'pagina' => 'pregunta',
            'categoria' => $categorias[$cat]['nombre'],
            'color_fondo' => $categorias[$cat]['color'],
            'color_pregunta' => $categorias[$cat]['color_pregunta'],
        ];

        $this->view->render("Pregunta", $data);
    }
}