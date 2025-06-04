<?php

class PerfilModel
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

    public function borrarImagenPerfil($nombre_usuario)
    {
        $imagen = $this->obtenerImagenPerfil($nombre_usuario);

        if (!empty($imagen)) {
            $this->eliminarArchivoImagen($imagen);
            $this->limpiarCampoImagen($nombre_usuario);
        }

        return true;
    }

    public function ObtenerImagenPerfil($nombre_usuario)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare("SELECT foto_perfil FROM usuario WHERE nombre_usuario = ?");
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $imagen = $result->fetch_assoc();
        return $imagen["foto_perfil"];
    }

    public function getIdUsuario()
    {

    }
    public function eliminarArchivoImagen($nombre_archivo)
    {

        $ruta_imagen = "./public/imagenesUsuarios/" . $nombre_archivo;
        if (file_exists($ruta_imagen)) {
            unlink($ruta_imagen); // elimina el archivo
        }
    }

    public function limpiarCampoImagen($nombre_usuario)
    {
        $conn = $this->connect();
        $stmt = $conn->prepare("UPDATE usuario SET foto_perfil = NULL WHERE nombre_usuario = ?");
        if (!$stmt) {
            die("Error en prepare (UPDATE): " . $conn->error);
        }
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();

        return true;

    }


    public function cambiarImagenPerfil($nombre_usuario, $nueva_imagen){

        // 3. Actualizar la base de datos con la nueva imagen
        $conn = $this->connect();
        $stmt = $conn->prepare("UPDATE usuario SET foto_perfil = ? WHERE nombre_usuario = ?");
        if (!$stmt) {
            die("Error en prepare (UPDATE): " . $conn->error);
        }
        $stmt->bind_param("ss", $nueva_imagen, $nombre_usuario);
        $stmt->execute();

        return true;
    }

    public function getUsuarioConFoto($nombre)
    {
        $usuario = $this->getUsuario($nombre);

        if ($usuario) {
            $foto = $usuario['foto_perfil'];
            if ($foto === null || !file_exists('./public/imagenesUsuarios/' . $foto)) {
                $usuario['foto_perfil'] = 'default.png';
            }
        }

        return $usuario;
    }


}