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

    public function getPreguntasSolicitadas()
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM pregunta_solicitada");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    // Buscar todas las preguntas por enunciado o nombre de categoría
    public function getPreguntasBuscadas($busqueda)
    {
        $conn = $this->connect();
        $busqueda = '%' . strtolower(trim($busqueda)) . '%';

        $stmt = $conn->prepare("
        SELECT p.*, c.nombre AS nombreCategoria
        FROM pregunta p
        LEFT JOIN categoria c ON p.id_categoria = c.id
        WHERE LOWER(p.enunciado) LIKE ? OR LOWER(c.nombre) LIKE ?
        ORDER BY p.id
    ");
        $stmt->bind_param("ss", $busqueda, $busqueda);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

// Buscar preguntas reportadas por enunciado o nombre de categoría
    public function getPreguntasBuscadasReportadas($busqueda)
    {
        $conn = $this->connect();
        $busqueda = '%' . strtolower(trim($busqueda)) . '%';

        $stmt = $conn->prepare("
        SELECT p.id AS idPregunta, p.enunciado, c.nombre AS nombreCategoria
        FROM pregunta p
        INNER JOIN pregunta_reportada pr ON p.id = pr.idPregunta
        LEFT JOIN categoria c ON p.id_categoria = c.id
        WHERE LOWER(p.enunciado) LIKE ? OR LOWER(c.nombre) LIKE ?
        ORDER BY p.id
    ");
        $stmt->bind_param("ss", $busqueda, $busqueda);
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

    public function getNombreCategoria($id_categoria)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT nombre FROM categoria WHERE id = ?");
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['nombre'] : null;
    }

    public function getPreguntasReportadas(): array
    {
        $conn = $this->connect();

        $sql = "SELECT *
            FROM pregunta p
            INNER JOIN pregunta_reportada pr ON p.id = pr.idPregunta";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        $preguntas = [];
        while ($row = $result->fetch_assoc()) {
            $preguntas[] = $row;
        }
        return $preguntas;
    }

    public function getPreguntaReportadaPorId($id_pregunta)
    {
        $conn = $this->connect();

        $sql = "SELECT 
                p.id AS id,
                p.enunciado,
                p.id_categoria,
                p.id_dificultad,
                pr.id AS id_reporte
            FROM pregunta p
            INNER JOIN pregunta_reportada pr ON p.id = pr.idPregunta
            WHERE p.id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_pregunta);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row ?: [];
    }


    public function getRespuestasReportadas($id_pregunta): array
    {
        $conn = $this->connect();
        $sql = "SELECT r.* 
            FROM respuesta r
            JOIN pregunta_reportada pr ON r.id_pregunta = pr.idPregunta
            WHERE pr.idPregunta = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_pregunta);
        $stmt->execute();

        $result = $stmt->get_result();
        $respuestas = [];
        while ($row = $result->fetch_assoc()) {
            $respuestas[] = $row;
        }
        return $respuestas;
    }


    public function eliminarPreguntaReportada($id_pregunta)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare("
        DELETE r FROM respuesta r
        JOIN pregunta_reportada pr ON r.id_pregunta = pr.idPregunta
        WHERE pr.idPregunta = ?
    ");
        $stmt->bind_param("i", $id_pregunta);
        $stmt->execute();

        $this->borrarReporte($id_pregunta);

        $stmt = $conn->prepare("DELETE FROM pregunta WHERE id = ?");
        $stmt->bind_param("i", $id_pregunta);
        $stmt->execute();
    }

    public function borrarReporte($id_pregunta)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("DELETE FROM pregunta_reportada WHERE idPregunta = ?");
        $stmt->bind_param("i", $id_pregunta);
        $stmt->execute();

    }

    public function getAllPreguntas()
    {
        $conn = $this->connect();
        $sql = "SELECT * FROM pregunta";
        $result = $conn->query($sql);

        if (!$result) {
            return []; // o lanzar error según convenga
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getAllPreguntasBuscadas($busqueda)
    {
        $conn = $this->connect();
        $busqueda = '%' . strtolower(trim($busqueda)) . '%';
        $sql = "SELECT p.*, c.nombre AS nombreCategoria
            FROM pregunta p
            LEFT JOIN categoria c ON p.id_categoria = c.id
            WHERE LOWER(p.enunciado) LIKE ? OR LOWER(c.nombre) LIKE ?
            ORDER BY p.id";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $busqueda, $busqueda);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
