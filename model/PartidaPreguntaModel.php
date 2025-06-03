<?php

class PartidaPreguntaModel
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

    public function registrarTurno($idPartida, $idPregunta, $esCorrecta)
    {
        $conn = $this->connect();
        $sql = "INSERT INTO partida_pregunta (id_partida, id_pregunta, respondida_correctamente) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $idPartida, $idPregunta, $esCorrecta);
        $stmt->execute();
    }

    public function esCorrecta($idPartida, $idPregunta){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT respondida_correctamente FROM partida_pregunta WHERE id_partida = ? AND id_pregunta = ?");
        $stmt->bind_param("ii", $idPartida, $idPregunta);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row && $row['respondida_correctamente'] == 1;
    }



}