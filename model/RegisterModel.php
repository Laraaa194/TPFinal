<?php

class RegisterModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function connect(){
        return $this->database->getConnection();
}
    public function getUsuario($nombre_usuario)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE nombre_usuario = ?");
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getIdSexos($sexo)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT id_sexo FROM sexo WHERE descripcion = ?");
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }
        $stmt->bind_param("s", $sexo);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row) {
            return $row['id_sexo'];
        }
        return null;
    }

    public function getCorreoUsuario($correo)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }
        $stmt->bind_param("s", $correo);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function add($nombre,$apellido, $anioNacimiento,$sexo,$email,$password,$nombreUsuario,$foto,$pais,$ciudad)
    {
        $conn = $this->connect();
        $sql = "INSERT INTO usuario (nombre, apellido, anio_Nacimiento, id_sexo, email,
                     password, nombre_usuario, foto_perfil, id_pais, id_ciudad) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $nombre, $apellido, $anioNacimiento, $sexo, $email, $password, $nombreUsuario, $foto, $pais, $ciudad);
        $stmt->execute();
    }
}