<?php

class PreguntaModel
{
    private $database;

    private $preguntaUsuarioModel;

    public function __construct($database, $preguntaUsuarioModel)
    {
        $this->database = $database;
        $this->preguntaUsuarioModel = $preguntaUsuarioModel;
    }

    public function connect(){
        return $this->database->getConnection();
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

    public function getPreguntaConRespuestas(int $idCategoria, int $idDificultad)
    {
        $maxIntentos = $this->getCantidadPreguntas($idCategoria, $idDificultad);
        $intentos = 0;

        do {
            $pregunta = $this->getPreguntaPorDificultadYCategoria($idCategoria, $idDificultad);
            $intentos++;
            if (!$pregunta) {
                return null;
            }
            $estaReportada = $this->verificarSiLaPreguntaEstaReportada($pregunta['id']);

        }while($estaReportada && $intentos < $maxIntentos);

        $respuestas = $this->getRespuestas($pregunta['id']);

        return [
            'pregunta' => $pregunta,
            'respuestas' => $respuestas
        ];
    }

    public function verificarSiLaPreguntaEstaReportada($idPregunta){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM pregunta_reportada WHERE idPregunta = ?");
        $stmt->bind_param("i", $idPregunta);
        $stmt->execute();
        $result = $stmt->get_result();

        return  $result->num_rows > 0;
    }

    public function getCantidadPreguntas($id_categoria, $idDificultad) {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT COUNT(*) as cantidad FROM pregunta WHERE id_categoria = ? AND id_dificultad = ?");
        $stmt->bind_param("ii", $id_categoria, $idDificultad);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['cantidad'];
    }

    public function sumarPunto($idPartida)
    {
        $conn = $this->connect();
        $sql = "UPDATE partida SET puntaje_total = puntaje_total + 1 WHERE id = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idPartida);
        $stmt->execute();
    }

    public function obtenerPreguntaNoRepetida($idUsuario, $idCategoria, $idDificultad) {
        $maxIntentos = $this->getCantidadPreguntas($idCategoria, $idDificultad);
        $intentos = 0;

        do {
            $dataPregunta = $this->getPreguntaConRespuestas($idCategoria, $idDificultad);
            if (!$dataPregunta) return null;

            $pregunta = $dataPregunta['pregunta'];
            $intentos++;
        } while (
            $this->preguntaUsuarioModel->getPreguntaRepetida($idUsuario, $pregunta['id']) !== null
            && $intentos < $maxIntentos
        );

        if ($intentos >= $maxIntentos) {
            $this->preguntaUsuarioModel->eliminarRegistroDePreguntasContestadas($idUsuario, $idCategoria);
            do {
                $dataPregunta = $this->getPreguntaConRespuestas($idCategoria, $idDificultad);
                if (!$dataPregunta) return null;

                $pregunta = $dataPregunta['pregunta'];
            } while ($this->preguntaUsuarioModel->getPreguntaRepetida($idUsuario, $pregunta['id']) !== null);
        }

        return $dataPregunta;
    }

    public function getPreguntaPorDificultadYCategoria($idCategoria, $idDificultad)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare("
        SELECT p.* FROM pregunta p
        JOIN dificultad d ON p.id_dificultad = d.id
        WHERE p.id_categoria = ? AND d.id = ?
    ");
        $stmt->bind_param("ii", $idCategoria, $idDificultad);
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

    function getEnunciadoDeLaPreguntaPorId($id){
        $con = $this->connect();
        $stmt = $con->prepare("
        SELECT enunciado FROM pregunta p 
                   WHERE id=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row;
        } else {
            return null;
        }
    }

    function guardarReporte($idPregunta,$idReporteMotivo,$fechaReporte,$estaVerificada){
        $con = $this->connect();
        $stmt = $con->prepare("INSERT INTO 
       pregunta_reportada (idPregunta,idReporteMotivo,fechaReporte,estaVerificada) 
            VALUES ( ?,?,?,?) "
        );
        $stmt->bind_param("iisi",$idPregunta,$idReporteMotivo, $fechaReporte ,$estaVerificada);
        $stmt->execute();
    }



    public function setDificultadPregunta($idPregunta)
    {
        $conn = $this->connect();

        $stmtTotal = $conn->prepare("SELECT COUNT(*) as total FROM partida_pregunta WHERE id_pregunta = ?");
        $stmtTotal->bind_param("i", $idPregunta);
        $stmtTotal->execute();
        $resultTotal = $stmtTotal->get_result();
        $total = $resultTotal->fetch_assoc()['total'];
        $stmtTotal->close();


        if ($total < 10) {
            return;
        }

        $stmtCorrectas = $conn->prepare("SELECT COUNT(*) as correctas FROM partida_pregunta WHERE id_pregunta = ? AND respondida_correctamente = 1");
        $stmtCorrectas->bind_param("i", $idPregunta);
        $stmtCorrectas->execute();
        $resultCorrectas = $stmtCorrectas->get_result();
        $correctas = $resultCorrectas->fetch_assoc()['correctas'];
        $stmtCorrectas->close();


        $porcentaje = ($correctas / $total) * 100;


        if ($porcentaje >= 70) {
            $idDificultad = 1; // fácil
        } elseif ($porcentaje >= 30) {
            $idDificultad = 2; // media
        } else {
            $idDificultad = 3; // difícil
        }


        $stmtUpdate = $conn->prepare("UPDATE pregunta SET id_dificultad = ? WHERE id = ?");
        $stmtUpdate->bind_param("ii", $idDificultad, $idPregunta);
        $stmtUpdate->execute();
        $stmtUpdate->close();
    }







}