<?php
require_once('../models/Proyecto.php');
require_once('../database/db.php');
session_start();

$email = isset($_SESSION['email'])? $_SESSION['email']: null;
if ($email == null) {
    header('location: ../index.php');
    exit();
}


$db = conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = isset($_POST['titulo'])? $_POST['titulo']: null;
    $descripcion = isset($_POST['descripcion'])? $_POST['descripcion']: null;
    $fecha_inicio = isset($_POST['fecha_inicio'])? $_POST['fecha_inicio']: null;
    $fecha_entrega = isset($_POST['fecha_entrega'])? $_POST['fecha_entrega']: null;
    $valor = isset($_POST['valor'])? $_POST['valor']: null;
    $lugar = isset($_POST['lugar'])? $_POST['lugar']: null;
    

    $stmt = $db->prepare("SELECT Id_persona FROM personas WHERE email = '$email'");
    $stmt->execute();
    $response = $stmt->fetch(PDO::FETCH_ASSOC);

    $responsable = $response['Id_persona'];
    $sql = Proyecto::crear($descripcion, $fecha_inicio, $fecha_entrega, $valor, $lugar, $responsable, $titulo);
    $stmt = $db->prepare($sql);
    $stmt->execute();
    header('location: ../views/main.php');
    exit();
}
else {
    if (isset($_GET['proyecto'])) {
        $proyecto = $_GET['proyecto'];
        $stmt = $db->prepare("UPDATE proyectos SET estado = 'Finalizado' WHERE id_proyecto = $proyecto");
        $stmt->execute();
        header('location: ../views/main.php');
        exit();
    }
}
?>