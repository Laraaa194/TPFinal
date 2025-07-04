<?php

class HistorialModeracionModel
{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function connect()
    {
        return $this->database->getConnection();
    }

    public function registrarEdicionPregunta($idEditor, $pregunta, $categoria)
    {
        $tipoAccion = 'Editar Pregunta';
        $detalle = 'Se efectuaron cambios en la pregunta: "' . $pregunta['enunciado'] . '".';
        $this->registrarAccion($idEditor, $tipoAccion, $detalle, $categoria);
    }
    public function registrarEliminacionPregunta($idEditor, $pregunta, $categoria)
    {
        $tipoAccion = 'Eliminar Pregunta';
        $detalle = 'Se eliminó la pregunta: "' . $pregunta['enunciado'] . '" y deja de estar activa.';
        $this->registrarAccion($idEditor, $tipoAccion, $detalle, $categoria);
    }
    public function registrarCreacionPregunta($idEditor, $enunciado, $categoria)
    {
        $tipoAccion = 'Agregar Pregunta';
        $detalle = 'Se agregó una nueva pregunta: "' . $enunciado . '" y pasa a estar activa.';
        $this->registrarAccion($idEditor, $tipoAccion, $detalle, $categoria);
    }
    public function registrarEliminacionReporte($idEditor, $pregunta, $categoria)
    {
        $tipoAccion = 'Eliminar Reporte';
        $detalle = 'Se eliminó la pregunta reportada: "' . $pregunta['enunciado'] . '".';
        $this->registrarAccion($idEditor, $tipoAccion, $detalle, $categoria);
    }

    public function registrarDenegacionReporte($idEditor, $pregunta, $categoria)
    {
        $tipoAccion = 'Denegar reporte';
        $detalle = 'Se denegó el reporte de la pregunta: "' . $pregunta['enunciado'] . '".';
        $this->registrarAccion($idEditor, $tipoAccion, $detalle, $categoria);
    }

    public function registrarAceptacionPreguntaSugerida($idEditor, $pregunta, $categoria)
    {
        $tipoAccion = 'Aceptar Solicitud';
        $detalle = 'Se aceptó la pregunta sugerida: "' . $pregunta['enunciado'] . '" y se añadió como pregunta activa.';
        $this->registrarAccion($idEditor, $tipoAccion, $detalle, $categoria);
    }

    public function registrarRechazoPreguntaSugerida($idEditor, $pregunta, $categoria)
    {
        $tipoAccion = 'Rechazar Solicitud';
        $detalle = 'Se rechazó la pregunta sugerida: "' . $pregunta['enunciado'] . '" y se eliminó la solicitud.';
        $this->registrarAccion($idEditor, $tipoAccion, $detalle, $categoria);
    }
    public function registrarAccion($idEditor, $tipoAccion, $detalle, $categoria)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("INSERT INTO historial_moderacion (id_editor, tipo_accion, detalle, categoria_pregunta) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $idEditor, $tipoAccion, $detalle, $categoria);
        $stmt->execute();
    }

    public function getHistorial()
    {
        $conn = $this->connect();
        $sql = "SELECT 
            hm.*, 
            u.nombre_usuario, 
            c.nombre AS nombre_categoria
        FROM historial_moderacion hm
        JOIN usuario u ON hm.id_editor = u.id_usuario
        LEFT JOIN categoria c ON hm.categoria_pregunta = c.id
        ORDER BY hm.fecha DESC";

        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }




}