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

    public function getPregunta()
    {
        $min = 1;
        $max = 200;
        $numeroRandom = mt_rand($min, $max);
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM pregunta WHERE id = ?");
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }
        $stmt->bind_param("i", $numeroRandom);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getRespuestas($id_pregunta){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM respuesta WHERE id_pregunta = ?");
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }
        $stmt->bind_param("i", $id_pregunta);
        $stmt->execute();

        $result = $stmt->get_result();
        $respuestas = []; // Inicializa un array vacío para almacenar todas las respuestas
        while ($row = $result->fetch_assoc()) {
            $respuestas[] = $row; // Agrega cada fila (respuesta) al array
        }
        return $respuestas;
    }
    public function getCategorias($id_categoria){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM categoria WHERE id = ?");
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }
        $stmt->bind_param("s", $id_categoria);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();

    }
}