<?php

class PreguntasEditorModel
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

    public function getPreguntasSolicitadas(){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM pregunta_solicitada");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getPreguntasBuscadas($busqueda){
        $conn = $this->connect();
        $busqueda = '%' . strtolower(trim($busqueda)) . '%';
        $stmt = $conn->prepare("SELECT * FROM pregunta_solicitada WHERE LOWER(enunciado) LIKE ?");
        $stmt->bind_param("s", $busqueda);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getPreguntaYRespuestas($id_pregunta): array
    {

        $pregunta = $this->getPregunta($id_pregunta);
        $respuestas = $this->getRespuestas($id_pregunta);

        return [
            'pregunta' => $pregunta,
            'respuestas' => $respuestas
        ];

    }
    public function getPregunta($id_pregunta)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM pregunta_solicitada WHERE id = ?");
        $stmt->bind_param("i", $id_pregunta);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();


    }

    public function getRespuestas($id_pregunta): array
    {

        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM respuesta_solicitada WHERE id_pregunta = ?");

        $stmt->bind_param("i", $id_pregunta);
        $stmt->execute();

        $result = $stmt->get_result();
        $respuestas = [];
        while ($row = $result->fetch_assoc()) {
            $respuestas[] = $row;
        }
        return $respuestas;
    }

    public function getNombreCategoria($id_categoria){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT nombre FROM categoria WHERE id = ?");
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['nombre'] : null;
    }
}