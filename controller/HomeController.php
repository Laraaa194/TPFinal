<?php

class HomeController
{
    private $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function show()
    {

        $data = ['pagina' => 'home', 'rutaLogo' => '/TPFinal/Home/show', 'mostrarLogo' => true];
        $this->view->render("paginaInicio", $data);
    }
}