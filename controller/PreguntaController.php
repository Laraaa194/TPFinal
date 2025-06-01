<?php

class PreguntaController
{
    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function getPregunta()
    {
        return $this->model->getPregunta();
    }

    public function getRespuestas($id_pregunta)
    {
        return $this->model->getPregunta($this->model->getRespuestas($id_pregunta));
    }

    public function getCategoria($id_categoria)
    {
        return $this->model->getPregunta($this->model->getCategoria($id_categoria));
    }






}