<?php

class PreguntaUsuarioModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function connect(){
        return $this->database->getConnection();
    }


    public function registrarPreguntaUsuario($idUsuario,$idPregunta, $idRespuestaElegida,$esCorrecta)
    {
        $conn = $this->connect();
        $sql = "INSERT INTO pregunta_usuario (idusuario,idpregunta,id_respuesta_elegida, es_correcta) 
        VALUES (?, ?, ?, ?)";


        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii",$idUsuario,$idPregunta, $idRespuestaElegida,$esCorrecta);
        $stmt->execute();
    }

    public function getPreguntaRepetida($idUsuario, $idPregunta){
        $conn = $this->connect();
        $sql = "SELECT * FROM pregunta_usuario WHERE idusuario = ? AND idpregunta = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii",$idUsuario,$idPregunta);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc(); //devuelve un array o null

    }

    public function eliminarRegistroDePreguntasContestadas($idUsuario, $idCategoria){
        $conn = $this->connect();
        $sql = "DELETE FROM pregunta_usuario 
            WHERE idusuario = ? 
            AND idpregunta IN (
                SELECT id FROM pregunta WHERE id_categoria = ?
            )";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $idUsuario, $idCategoria);
        $stmt->execute();
    }


}