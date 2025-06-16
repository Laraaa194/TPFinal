<?php

class PreguntaEditorController
{
    private $view;
    private $Model;

    public function __construct($view)
    {
        $this->view = $view;

    }

    public function create() {
        // mostrar formulario
    }

    public function listar() {
        // mostrar listado de preguntas con editar/eliminar
    }

    public function verReportadas() {
        // listar preguntas reportadas
    }

    public function verSugerencias() {
        // listar sugeridas para aprobar o descartar
    }


}