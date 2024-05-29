<?php
include_once '../database/db.php';

class Tarea {
    
    static function listarTareas($id) {
        return "SELECT * FROM tareas WHERE Id_actividad = $id";
    }

    static function crear($descripcion, $fecha_inicio, $fecha_final, $id_actividad, $presupuesto) {
        return "INSERT INTO tareas(Descripcion, Fecha_inicio, Fecha_final, Id_actividad, Presupuesto) VALUES ('$descripcion', '$fecha_inicio', '$fecha_final', $id_actividad, $presupuesto)";
    }

    static function buscar($id_tarea) {
        $sql = "SELECT * FROM tareas WHERE id_tarea='$id_tarea'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    static function actualizar($id_tarea) {
        return "UPDATE tareas SET Estado='Finalizado' WHERE id_tarea=$id_tarea";
    }
}
?>
