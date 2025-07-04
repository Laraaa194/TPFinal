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
            SELECT 'Correctas' AS tipo_respuesta
            FROM pregunta_usuario
            WHERE es_correcta = 1

            UNION ALL

         
            SELECT 'Incorrectas' AS tipo_respuesta
            FROM pregunta_usuario
            WHERE es_correcta = 0

            UNION ALL

          
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


        return [
            'por_categoria' => $preguntasPorCategoria,
            'por_dificultad' => $preguntasPorDificultad
        ];
    }


    public function obtenerPreguntasCreadas()
    {
        $conn = $this->connect();

        $sql = "
            SELECT 
                c.nombre AS categoria,
                COALESCE(SUM(CASE WHEN h.tipo_accion = 'Agregar pregunta' THEN 1 ELSE 0 END), 0) AS agregadas_por_editor,
                COALESCE(SUM(CASE WHEN h.tipo_accion = 'Aceptar solicitud' THEN 1 ELSE 0 END), 0) AS aceptadas_de_jugadores
            FROM categoria c
            LEFT JOIN historial_moderacion h ON h.categoria_pregunta = c.id
            GROUP BY c.id
            ORDER BY c.nombre
            ";

        $result = $conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPartidasAgrupadasPor($criterio)
    {
        $conn = $this->connect();


        switch ($criterio) {
            case 'dia':
                $formato = '%Y-%m-%d';
                break;
            case 'semana':
                $formato = '%Y-%u';
                break;
            case 'mes':
                $formato = '%Y-%m';
                break;
            case 'anio':
                $formato = '%Y';
                break;
            default:
                $formato = '%Y-%m';
                break;
        }

        $sql = "
        SELECT DATE_FORMAT(fecha, '$formato') AS periodo, COUNT(*) AS cantidad
        FROM partida
        GROUP BY periodo
        ORDER BY periodo ASC
    ";

        $result = $conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function obtenerJugadoresNuevosPor($filtro)
    {
        $conn = $this->connect();

        switch ($filtro) {
            case 'dia':
                $group = "DATE(u.fecha_registro)";
                $select = "DATE(u.fecha_registro) AS periodo";
                break;
            case 'semana':
                $group = "YEAR(u.fecha_registro), WEEK(u.fecha_registro)";
                $select = "CONCAT(YEAR(u.fecha_registro), '-S', LPAD(WEEK(u.fecha_registro), 2, '0')) AS periodo";
                break;
            case 'mes':
                $group = "YEAR(u.fecha_registro), MONTH(u.fecha_registro)";
                $select = "DATE_FORMAT(u.fecha_registro, '%Y-%m') AS periodo";
                break;
            case 'anio':
                $group = "YEAR(u.fecha_registro)";
                $select = "YEAR(u.fecha_registro) AS periodo";
                break;
            default:
                $group = "DATE(u.fecha_registro)";
                $select = "DATE(u.fecha_registro) AS periodo";
                break;
        }

        $sql = "SELECT $select, COUNT(*) AS cantidad
            FROM usuario u
            WHERE u.id_tipo = 1 
            GROUP BY $group
            ORDER BY u.fecha_registro ASC";

        $result = $conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerJugadoresActivos($criterio)
    {
        $conn = $this->connect();

        switch ($criterio) {
            case 'dia':
                $formato = '%Y-%m-%d';
                break;
            case 'semana':
                $formato = '%Y-%u';
                break;
            case 'mes':
                $formato = '%Y-%m';
                break;
            case 'anio':
                $formato = '%Y';
                break;
            default:
                $formato = '%Y-%m-%d';
                break;
        }

        $sql = "
        SELECT DATE_FORMAT(fecha, '$formato') AS periodo, COUNT(DISTINCT id_jugador) AS cantidad
        FROM partida
        GROUP BY periodo
        ORDER BY periodo ASC
    ";

        $result = $conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerJugadoresPorPais()
    {
        $conn = $this->connect();
        $sql =  "SELECT 
        CASE 
            WHEN latitud BETWEEN -56 AND -20 AND longitud BETWEEN -76 AND -53 THEN 'Argentina'
            WHEN latitud BETWEEN -36 AND -29 AND longitud BETWEEN -58 AND -53 THEN 'Uruguay'
            WHEN latitud BETWEEN 35 AND 45 AND longitud BETWEEN -10 AND 5 THEN 'España'
            WHEN latitud BETWEEN -5 AND 14 AND longitud BETWEEN -80 AND -65 THEN 'Colombia'
            WHEN latitud BETWEEN -5 AND 3 AND longitud BETWEEN -83 AND -74 THEN 'Ecuador'
            WHEN latitud BETWEEN 7 AND 10 AND longitud BETWEEN -83 AND -77 THEN 'Panamá'
            ELSE 'Otro'
        END AS pais,
        COUNT(*) AS cantidad
    FROM usuario
    GROUP BY pais
    ORDER BY cantidad DESC";

        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }




}