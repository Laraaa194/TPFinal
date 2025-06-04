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

    public function getIdPartida($idJugador){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT id FROM partida WHERE id_jugador = ? AND esta_activa = true");
        $stmt->bind_param("i", $idJugador);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['id'];
        }
        return null;
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

    public function getPartidaActiva($idUsuario)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM partida WHERE id_jugador = ? AND esta_activa = 1 ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    public function addPartida($idJugador, $esta_activa)
    {
        $conn = $this->connect();
        $sql = "INSERT INTO partida (id_jugador,esta_activa) 
        VALUES (?, ?)";

        $stmt = $conn->prepare($sql);


        $stmt->bind_param("ii",$idJugador, $esta_activa);
        $stmt->execute();

    }


    public function terminarPartida($idJugador, $puntajeTotal)
    {
        $conn = $this->connect();

        $sql = "UPDATE partida SET esta_activa = false, puntaje_total = ? WHERE id_jugador = ? AND esta_activa = true";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii",$puntajeTotal,$idJugador);
        $stmt->execute();
    }



    public function getPartidas($idJugador){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT fecha, puntaje_total FROM partida WHERE id_jugador = ?");
        $stmt->bind_param("i", $idJugador);
        $stmt->execute();
        $result = $stmt->get_result();
        $partidas = [];
        while ($row = $result->fetch_assoc()) {
            $partidas[] = $row;
        }
        return $partidas;
}


}