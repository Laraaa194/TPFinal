<?php

class LoginModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getUsuario($nombre_usuario)
    {
        $conn = $this->database->getConnection();
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE nombre_usuario = ? ");
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


}