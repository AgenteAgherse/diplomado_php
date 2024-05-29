<?php
include_once '../database/db.php';

class Recurso {
    private $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    function listar() {
        $sql = "SELECT * FROM recursos";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $recursos = array();
            while ($row = $result->fetch_assoc()) {
                $recursos[] = $row;
            }
            return $recursos;
        } else {
            return array();
        }
    }

    function crear($descripcion, $valor, $unidad_de_medida) {
        $sql = "INSERT INTO recursos (descripcion, valor, unidad_de_medida)
        VALUES ('$descripcion', '$valor', '$unidad_de_medida')";

        if ($this->conn->query($sql) === TRUE) {
            return "Recurso creado correctamente.";
        } else {
            return "Error al crear recurso.";
        }
    }

    function buscar($id_recurso) {
        $sql = "SELECT * FROM recursos WHERE id_recurso='$id_recurso'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    function actualizar($id_recurso, $descripcion, $valor, $unidad_de_medida) {
        $sql = "UPDATE recursos SET descripcion='$descripcion', valor='$valor', unidad_de_medida='$unidad_de_medida' WHERE id_recurso='$id_recurso'";
        if ($this->conn->query($sql) === TRUE) {
            return "Recurso actualizado correctamente.";
        } else {
            return "Error al actualizar recurso.";
        }
    }
}
?>
