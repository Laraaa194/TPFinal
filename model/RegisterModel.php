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
        $Sexo= strtolower($sexo);

        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT id_sexo FROM sexo WHERE LOWER(descripcion) = ?");
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }
        $stmt->bind_param("s", $Sexo);
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

    public function add($nombre,$apellido, $anioNacimiento,$sexo,$email,$password,$nombreUsuario,$foto,$latitud,$longitud, $tipo)
    {
        $token = $this->generarToken();
        $conn = $this->connect();
            $sql = "INSERT INTO usuario (
        nombre, apellido, anio_Nacimiento, id_sexo, email,
        password, nombre_usuario, foto_perfil,
        id_tipo, token,
        latitud, longitud) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssissssiidd",
            $nombre, $apellido, $anioNacimiento, $sexo, $email,
            $password, $nombreUsuario, $foto,
            $tipo, $token, $latitud, $longitud
        );
        $stmt->execute();
        return $token;
    }

    public function verificar($token,$idJugador){
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE id_usuario = ? AND token = ? AND es_valido = 0");

        $stmt->bind_param("ii", $idJugador, $token);

        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function validar($idJugador){
        $conn = $this->connect();
        $stmt = $conn->prepare("UPDATE usuario SET es_valido = 1, token = NULL WHERE id_usuario = ?");
        $stmt->bind_param("i", $idJugador);
        return $stmt->execute();
    }
    private function generarToken(){
        $token= random_int(100000, 999999);
        while ($this->existeToken($token)){
            $token = random_int(100000, 999999);
        }
        return $token;
    }

    private function existeToken($token){
        $conn = $this->connect();

        $stmt = $conn->prepare("SELECT 1 FROM usuario WHERE token = ? LIMIT 1");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }
}