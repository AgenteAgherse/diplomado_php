<?php
include_once '../database/db.php';
include_once '../models/Tarea.php';


$db = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tarea = isset($_POST['tareaxpersona'])? $_POST['tareaxpersona']: null;
    if ($tarea != null) {
        $persona = isset($_POST['persona'])? $_POST['persona']: null;
        $duracion = isset($_POST['duracion'])? $_POST['duracion']: null;
        $sql = "INSERT INTO tareaxpersona(Id_tarea, Id_persona, Duracion) VALUES ($tarea, $persona, $duracion)";
        echo $sql;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        header('location: ../views/main.php');
        exit();
    }
    else if (isset($_POST['tareaxrecurso'])) {
        $tarea = $_POST['tareaxrecurso'];
        $recurso = $_POST['recurso'];
        $cantidad = $_POST['cantidad'];
        $sql = "SELECT * FROM tareaxrecurso WHERE id_tarea = $tarea AND id_recurso = $recurso";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $sql = "UPDATE tareaxrecurso SET cantidad=cantidad+$cantidad WHERE id_tarea = $tarea AND id_recurso = $recurso";
        }
        else {
            $sql = "INSERT INTO tareaxrecurso(Id_tarea, Id_recurso, Cantidad) VALUES ($tarea, $recurso, $cantidad)";
        }
        echo $sql;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        header('location: ../views/main.php');
        exit();
    }
    else {
        $actividad = isset($_POST['actividad'])? $_POST['actividad']: null;
        $proyecto = isset($_POST['proyecto'])? $_POST['proyecto']: null;
        $descripcion = isset($_POST['descripcion'])? $_POST['descripcion']: null;
        $fecha_inicio = isset($_POST['fecha_inicio'])? $_POST['fecha_inicio']: null;
        $fecha_final = isset($_POST['fecha_final'])? $_POST['fecha_final']: null;
        $presupuesto = isset($_POST['presupuesto'])? $_POST['presupuesto']: null;


        if ($actividad == null || $proyecto == null) {
            header('location: ../views/main.php');
            exit();
        }

        $redirect = "location: ../views/actividad.php?proyecto=".$proyecto."&actividad=".$actividad;
        echo $redirect;
        $sql = Tarea::crear($descripcion, $fecha_inicio, $fecha_final, $actividad, $presupuesto);
        
        $stmt=$db->prepare($sql);
        $stmt->execute();

        header($redirect);
        exit();
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $actividad = isset($_GET['actividad'])? $_GET['actividad']: null;
    $proyecto = isset($_GET['proyecto'])? $_GET['proyecto']: null;
    $tarea = isset($_GET['tarea'])? $_GET['tarea']: null;
    if ($actividad == null || $proyecto == null || $tarea == null) {
        header('location: ../views/main.php');
        exit();
    }

    $sql = Tarea::actualizar($tarea);
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $redirect = "location: ../views/actividad.php?proyecto=".$proyecto."&actividad=".$actividad;
    header($redirect);
    exit();
}
?>
