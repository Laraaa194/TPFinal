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

    public function getPregunta($id_categoria)
    {
        return $this->model->getPregunta($id_categoria);
    }

    public function getRespuestas($id_pregunta)
    {
        return $this->model->getRespuestas($id_pregunta);
    }

    public function esRespuestaCorrecta($idPregunta, $idRespuesta)
    {
    return $this->model->esRespuestaCorrecta($idPregunta,$idRespuesta);
    }


    public function getCategoria($id_categoria)
    {
        return $this->model->getCategorias($id_categoria);
    }







}