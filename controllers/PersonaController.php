<?php
include_once '../database/db.php';
include_once '../models/Persona.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $inicio = isset($_GET['inicio']);
    if ($inicio) {
        $email = isset($_POST['email'])? $_POST['email']: null;
        $password = isset($_POST['password'])? $_POST['password']: null;
        if ($email != null && $password != null) {

            if (Persona::consultar($email, $password)) {
                session_start();
                $_SESSION['email'] = $_POST['email'];
                header('location: ../views/main.php');
                exit();
            }
            else {
                header('location: ../index.php?error=true');
                exit();
            }

        }
        header('location: ../index.php?error=true');
        exit();
    }



    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $sexo = $_POST['sexo'];
    $fecha_nacimiento = $_POST['fechaNacimiento'];
    $profesion = $_POST['profesion'];
    // Sección de Registro
    if (isset($_GET['registro'])) {
        if (!Persona::verificarCorreo($_POST['correo'])) {
            $correo = $_POST['correo'];
            $contra = $_POST['password'];
            $mensaje = Persona::crear($nombre, $apellidos, $direccion, $telefono, $sexo, $fecha_nacimiento, $profesion, $identificacion, $correo, $contra);
            echo $mensaje;
            header('location: ../index.php?registro');
            exit();
        }

        header('location: ../views/registro.php?error=true');
        exit();
    }

    if (isset($_GET['personal'])) {
        $db = conectar();
        $stmt = $db->prepare("SELECT * FROM personas WHERE identificacion = :id");
        $stmt->bindParam(':id', $identificacion);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            $stmt = $db->prepare("INSERT INTO personas(Nombre, Apellidos, Direccion, Telefono, Sexo, Fecha_nacimiento, Profesion, identificacion) VALUES ('$nombre', '$apellidos', '$direccion', '$telefono', '$sexo', '$fecha_nacimiento', '$profesion', '$identificacion')");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                header('location: ../views/main.php');
                exit();
            }
        }
        http_response_code(400);
        header('location: ../views/main.php');
    }


}

if (isset($_GET['id_persona'])) {
    $id_persona = $_GET['id_persona'];
    error_log($id_persona);

    $datosPersona = $persona->buscar($id_persona);

    if ($datosPersona) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!$persona->verificarCorreo($_POST['correo'])) {
                $identificacion = $_POST['identificacion'];
                $correo = $_POST['email'];
                $contra = $_POST['password'];
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $direccion = $_POST['direccion'];
                $telefono = $_POST['telefono'];
                $sexo = $_POST['sexo'];
                $fecha_nacimiento = $_POST['fecha_nacimiento'];
                $profesion = $_POST['profesion'];

                $mensaje = $persona->actualizar($id_persona, $nombre, $apellidos, $direccion, $telefono, $sexo, $fecha_nacimiento, $profesion, $identificacion, $correo, $contra);
                header('location: ../index.php?registro=true');
                exit();
            }

            header('location: ../views/registro.php?error');
        }

        include_once '../vista/actualizarPersona.php';
    } else {
        echo "No se encontró ninguna persona con el ID proporcionado.";
    }
} else {
        
}

?>
