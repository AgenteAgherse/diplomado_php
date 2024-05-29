<?php
include_once '../database/db.php';

class Actividad {
    
    static function listar($proyecto) {
        return "SELECT * FROM actividades WHERE id_proyecto = $proyecto";
    }

    static function crear($descripcion, $fecha_inicio, $fecha_final, $id_proyecto, $presupuesto) {
        return "INSERT INTO actividades(Descripcion, Fecha_inicio, Fecha_final, Id_proyecto, Presupuesto) VALUES('$descripcion', '$fecha_inicio', '$fecha_final', $id_proyecto, $presupuesto)";
    }

    static function actualizar($id_actividad) {
        return "UPDATE actividades SET Estado = 'Finalizado' WHERE id_actividad = $id_actividad";
    }
}
?>
