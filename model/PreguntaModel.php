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

    public function getPregunta($id_categoria)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM pregunta WHERE id_categoria = ?");
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }

        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();

        $result = $stmt->get_result();
        $preguntas = [];

        while ($row = $result->fetch_assoc()) {
            $preguntas[] = $row;
        }

        // Elegir una pregunta aleatoria
        if (count($preguntas) > 0) {
            return $preguntas[array_rand($preguntas)];
        } else {
            return null;
        }
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
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();

    }
}