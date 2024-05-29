<?php
session_start();

$email = isset($_SESSION['email'])? $_SESSION['email']: null;
if ($email == null) { 
    header('location: ../index.php');
}

require_once('../database/db.php');

$db = conectar();

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $descripcion = isset($_POST['descripcion'])? $_POST['descripcion']: null;
    $valor = isset($_POST['valor'])? $_POST['valor']: null;
    $unidad = isset($_POST['unidad'])? $_POST['unidad']: null;

    $sql = "INSERT INTO recursos(Descripcion, Valor, Unidad_de_medida) VALUES ('$descripcion', $valor, '$unidad')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    header('location: ../views/main.php');
}
?>