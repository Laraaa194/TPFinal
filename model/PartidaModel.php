<?php

class PartidaModel
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

    public function getPartida($idPartida)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM partida WHERE id = ?");
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }
        $stmt->bind_param("i", $idPartida);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getPuntajeTotal($idPartida)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT puntaje_total FROM partida WHERE id = ?");
        $stmt->bind_param("i", $idPartida);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getEstadoPartida($idUsuario)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT estado FROM partida WHERE id_jugador = ?");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    public function addPartida($idJugador, $estado)
    {
        $conn = $this->connect();
        $sql = "INSERT INTO partida (id_jugador, estado) 
        VALUES (?, ?)";


        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $idJugador, $estado);
        $stmt->execute();
    }


//    public function terminarPartida($idJugador)
//    {
//        $conn = $this->connect();
//        $sql = "UPDATE partida SET estado = 'terminada' WHERE id_jugador = ? AND estado = 'activa'";
//
//        $stmt = $conn->prepare($sql);
//        $stmt->bind_param("i", $idJugador);
//        $stmt->execute();
//    }

}