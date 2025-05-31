<?php

class PreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function connect(){
        return $this->database->getConnection();
    }

    public function getPregunta(){


    }

    public function getCategorias(){


    }
}