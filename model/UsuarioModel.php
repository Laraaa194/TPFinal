<?php

class UsuarioModel
{

    private $database;


    public function __construct($database)
    {
        $this->database = $database;

    }

    public function connect(){
        return $this->database->getConnection();
    }


    public function incrementarPreguntasRecibidas($idUsuario)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("UPDATE usuario SET preguntas_recibidas = preguntas_recibidas + 1 WHERE id_usuario = ?");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
    }

    public function incrementarPreguntasAcertadas($idUsuario)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("UPDATE usuario SET preguntas_acertadas = preguntas_acertadas + 1 WHERE id_usuario = ?");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
    }

    public function nivelUsuario($idUsuario){


        $preguntasRecibidas = $this->getCantidadPreguntasRecibidas($idUsuario);
        $preguntasAcertadas = $this->getCantidadPreguntasAcertadas($idUsuario);


        if ($preguntasRecibidas < 10) {
            return 2; // Nivel por defecto
        }

        $porcentaje = ($preguntasAcertadas / $preguntasRecibidas) * 100;

        if ($porcentaje <= 30) {
            return 1;
        } elseif ($porcentaje <= 70) {
            return 2;
        } else {
            return 3;
        }
    }




    public function getCantidadPreguntasRecibidas($idUsuario){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT preguntas_recibidas FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? (int)$row['preguntas_recibidas'] : 0;
    }

    public function getCantidadPreguntasAcertadas($idUsuario){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT preguntas_acertadas FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? (int)$row['preguntas_acertadas'] : 0;
    }

}