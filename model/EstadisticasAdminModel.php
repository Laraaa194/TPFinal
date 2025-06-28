<?php

class EstadisticasAdminModel
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

    public function obtenerJugadoresPorSexo()
    {
        $conn = $this->connect();
        $sql = "
        SELECT s.descripcion AS sexo, COUNT(*) AS cantidad
        FROM usuario u 
        JOIN sexo s ON u.id_sexo = s.id_sexo
        WHERE u.id_tipo = 1
        GROUP BY s.descripcion
    ";

        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerJugadoresPorEdad()
    {
        $conn = $this->connect();

        $sql = "
        SELECT 
            CASE 
                WHEN (YEAR(CURDATE()) - anio_nacimiento) < 18 THEN 'Menores'
                WHEN (YEAR(CURDATE()) - anio_nacimiento) BETWEEN 18 AND 60 THEN 'Adultos'
                ELSE 'Mayores'
            END AS grupo_edad,
            COUNT(*) AS cantidad
        FROM usuario
        WHERE id_tipo = 1
        GROUP BY grupo_edad
    ";

        $result = $conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerCantidadRespondidas()
    {
        $conn = $this->connect();

        $sql = "
        SELECT tipo_respuesta, COUNT(*) AS cantidad FROM (
            -- Respondidas correctamente
            SELECT 'Correctas' AS tipo_respuesta
            FROM pregunta_usuario
            WHERE es_correcta = 1

            UNION ALL

            -- Respondidas incorrectamente
            SELECT 'Incorrectas' AS tipo_respuesta
            FROM pregunta_usuario
            WHERE es_correcta = 0

            UNION ALL

            -- No respondidas: preguntas que no están en pregunta_usuario
            SELECT 'No respondidas' AS tipo_respuesta
            FROM pregunta p
            WHERE p.id NOT IN (
                SELECT DISTINCT idpregunta FROM pregunta_usuario
            )
        ) AS resumen
        GROUP BY tipo_respuesta
    ";

        $result = $conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPreguntas()
    {
        $conn = $this->connect();

        // Preguntas por categoría
        $sqlCategorias = "
        SELECT 
            c.nombre AS categoria,
            c.color,
            c.color_fondo,
            COUNT(p.id) AS cantidad
        FROM pregunta p
        JOIN categoria c ON p.id_categoria = c.id
        GROUP BY c.id
    ";

        $resultCategorias = $conn->query($sqlCategorias);
        $preguntasPorCategoria = $resultCategorias->fetch_all(MYSQLI_ASSOC);

        // Preguntas por dificultad
        $sqlDificultades = "
        SELECT 
            d.nombre AS dificultad,
            COUNT(p.id) AS cantidad
        FROM pregunta p
        JOIN dificultad d ON p.id_dificultad = d.id
        GROUP BY d.id
    ";

        $resultDificultades = $conn->query($sqlDificultades);
        $preguntasPorDificultad = $resultDificultades->fetch_all(MYSQLI_ASSOC);

        // Devolver ambos conjuntos
        return [
            'por_categoria' => $preguntasPorCategoria,
            'por_dificultad' => $preguntasPorDificultad
        ];
    }



}