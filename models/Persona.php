<?php
include_once '../database/db.php';

class Persona {
    private $conn;

    static function listar() {
        $db = conectar();

        $sql = "SELECT * FROM personas";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $personas = array();
            while ($row = $result->fetch_assoc()) {
                $personas[] = $row;
            }
            return $personas;
        } else {
            return array();
        }
    }

    static function consultar($email, $password) {
        $db = conectar();
        $sql = "SELECT * FROM personas WHERE email = '$email' AND password = SHA('$password')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($resultados as $dat) {
            return true;
        }
        return false;

    }
    static function verificarCorreo($email) {
        $db = conectar();
        $stmt = $db->prepare("SELECT * FROM personas WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($resultados as $coincidencia) {
            return true;
        }
        return false;
    }

    static function crear($nombre, $apellidos, $direccion, $telefono, $sexo, $fecha_nacimiento, $profesion, $identificacion, $email, $password) {
        $db = conectar();
        $stmt = $db->prepare("INSERT INTO personas (nombre, apellidos, direccion, telefono, sexo, fecha_nacimiento, profesion, identificacion, email, password)
        VALUES ('$nombre', '$apellidos', '$direccion', '$telefono', '$sexo', '$fecha_nacimiento', '$profesion', '$identificacion', '$email', SHA('$password'))");
        $stmt->execute();
        if ($stmt->affected_rows) {
            return "Persona creada correctamente.";
        } else {
            return "Error al crear persona.";
        }
    }

    static function buscar($id_persona) {
        $sql = "SELECT * FROM personas WHERE id_persona='$id_persona'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    static function actualizar($id_persona, $nombre, $apellidos, $direccion, $telefono, $sexo, $fecha_nacimiento, $profesion) {
        $sql = "UPDATE personas SET nombre='$nombre', apellidos='$apellidos', direccion='$direccion', telefono='$telefono', sexo='$sexo', fecha_nacimiento='$fecha_nacimiento', profesion='$profesion' WHERE id_persona='$id_persona'";
        if ($this->conn->query($sql) === TRUE) {
            return "Persona actualizada correctamente.";
        } else {
            return "Error al actualizar persona.";
        }
    }
}
?>
