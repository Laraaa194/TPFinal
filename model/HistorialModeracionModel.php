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

    public function registrarAccion($idEditor, $tipoAccion, $detalle)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("INSERT INTO historial_moderacion (id_editor, tipo_accion, detalle) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $idEditor, $tipoAccion, $detalle);
        $stmt->execute();
    }

    public function getHistorial()
    {
        $conn = $this->connect();
        $sql = "SELECT hm.*, u.nombre_usuario FROM historial_moderacion hm 
                JOIN usuario u ON hm.id_editor = u.id_usuario ORDER BY hm.fecha DESC";

        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


}