<?php

class CrearPreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function connect()
    {
        return $this->database->getConnection();
    }

    public function getPreguntas($enunciado){
        $conn = $this->connect();

        $enunciadoLower = mb_strtolower($enunciado, 'UTF-8');

        $stmt = $conn->prepare("
        SELECT * FROM pregunta WHERE LOWER(enunciado) = ?");
        $stmt->bind_param("s", $enunciadoLower);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function addPreguntaSolicitada($idCategoria, $enunciado)
    {
        $conn = $this->connect();
        $sql = "INSERT INTO pregunta_solicitada (id_categoria, enunciado) 
        VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $idCategoria, $enunciado);
        $stmt->execute();

        return $conn->insert_id;
    }

    public function addRespuestaSolicitada($id_pregunta, $respuesta, $es_correcta)
    {
        $conn = $this->connect();
        $sql = "INSERT INTO respuesta_solicitada (id_pregunta, texto, es_correcta) 
        VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $id_pregunta, $respuesta, $es_correcta);
        $stmt->execute();
    }

    public function getPreguntasSolicitadas(){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM pregunta_solicitada");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
}




}