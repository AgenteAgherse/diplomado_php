<?php
include_once '../database/db.php';
include_once '../models/Actividad.php';


$db = conectar();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_proyecto = isset($_POST['id_proyecto'])? $_POST['id_proyecto']: null;
    $descripcion = isset($_POST['descripcion'])? $_POST['descripcion']: null;
    $fecha_inicio = isset($_POST['fecha_inicio'])? $_POST['fecha_inicio']: null;
    $fecha_final = isset($_POST['fecha_final'])? $_POST['fecha_final']: null;
    $presupuesto = isset($_POST['presupuesto'])? $_POST['presupuesto']: null;

    $sql = Actividad::crear($descripcion, $fecha_inicio, $fecha_final, $id_proyecto, $presupuesto);
    $stmt=$db->prepare($sql);
    $stmt->execute();
    header("location: ../views/proyecto.php?proyecto=".$id_proyecto);
    exit();
}
else {
    $actividad = isset($_GET['actividad'])? $_GET['actividad']: null;
    if ($actividad != null) { 
        $stmt = $db->prepare(Actividad::actualizar($actividad));
        $stmt->execute();
    }
    header("location: ../views/proyecto.php?proyecto=".$id_proyecto);
    exit();
}
?>
