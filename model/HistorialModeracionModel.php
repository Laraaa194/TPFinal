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