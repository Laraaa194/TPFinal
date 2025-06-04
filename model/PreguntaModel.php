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
        $respuestas = [];
        while ($row = $result->fetch_assoc()) {
            $respuestas[] = $row;
        }
        return $respuestas;
    }

    public function esRespuestaCorrecta($idPregunta, $idRespuesta){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT es_correcta FROM respuesta WHERE id = ? AND id_pregunta = ?");
        $stmt->bind_param("ii", $idRespuesta, $idPregunta);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row && $row['es_correcta'] == 1;
    }

    public function getRespuestaCorrectaId($preguntaId){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT id FROM respuesta WHERE id_pregunta = ?");
        $stmt->bind_param("i", $preguntaId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }
public function getIdCategoria($idPregunta){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT id_categoria FROM pregunta WHERE id = ?");
        $stmt->bind_param("i", $idPregunta);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
}

public function getColorCategoria($idCategoria){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT color FROM categoria WHERE id = ?");
        $stmt->bind_param("i", $idCategoria);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
}

public function getCategorias(): array
{

        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM categoria");
        $stmt->execute();
        $result = $stmt->get_result();
        $categorias = [];
        while ($row = $result->fetch_assoc()) {
            $categorias[] = $row;

        }
            return $categorias;
        }


    public function getCategoriaAleatoria(): array{

        $categorias = $this->getCategorias();
         return $categorias[array_rand($categorias)];

    }

    public function getPreguntaConRespuestas(int $idCategoria)
    {
        $pregunta = $this->getPregunta($idCategoria);

        if (!$pregunta) {
            return null;
        }

        $respuestas = $this->getRespuestas($pregunta['id']);

        return [
            'pregunta' => $pregunta,
            'respuestas' => $respuestas
        ];
    }

    public function sumarPunto($idPartida)
    {
        $conn = $this->connect();

        $sql = "UPDATE partida SET puntaje_total = puntaje_total + 1 WHERE id = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idPartida);
        $stmt->execute();
    }
}