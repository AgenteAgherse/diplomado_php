<?php
    require('../models/Tarea.php');
    require_once('../database/db.php');

    session_start();

    // Filtros
    $email = isset($_SESSION['email'])? $_SESSION['email']: null;
    if ($email == null) { 
        header('location: ./main.php');
        exit();
    }

    $proyecto = isset($_GET['proyecto'])? $_GET['proyecto']: null;
    $actividad = isset($_GET['actividad'])? $_GET['actividad']: null;
    $tarea = isset($_GET['tarea'])? $_GET['tarea']: null;
    if ($proyecto == null || $tarea == null || $actividad == null) {
        header('location: ./main.php');
        exit();
    }

    $db = conectar();
    $sql = "SELECT id_persona AS id, CONCAT(nombre, ' ', apellidos) AS nombre FROM personas WHERE email IS null AND password IS null  AND id_persona NOT IN (SELECT id_persona FROM tareaxpersona WHERE id_tarea = $tarea)";
    $stmtPersonas = $db->prepare($sql);
    $stmtPersonas->execute();
    $listado_personas = $stmtPersonas->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT id_recurso AS id, descripcion FROM recursos";
    $stmtRecursos = $db->prepare($sql);
    $stmtRecursos->execute();
    $listado_recursos = $stmtRecursos->fetchAll(PDO::FETCH_ASSOC);


    $sql = "SELECT  identificacion, CONCAT(nombre, ' ', apellidos) AS nombre, direccion, telefono 
    FROM personas WHERE id_persona IN(SELECT id_persona FROM tareaxpersona WHERE id_tarea = $tarea)";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $personas_registradas = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $sql = "SELECT descripcion, (valor*cantidad) AS total, cantidad FROM tareaxrecurso JOIN recursos ON tareaxrecurso.id_recurso = recursos.id_recurso WHERE id_tarea = $tarea";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $registros_tarea = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Cartas</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <script>
        function abrirModalTareas() {
            document.getElementById('modalTareas').classList.remove('hidden');
        }

        function cerrarModalTareas() {
            document.getElementById('modalTareas').classList.add('hidden');
        }
    </script>
</head>
<body class="bg-gray-100">
<div class=" text-center ml-20 mr-20 mt-10 grid gap-6 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
    <!-- Sección de Tareas X Recurso -->
    <div class='bg-white rounded-lg shadow-lg overflow-hidden'>
        <div class='p-6'>
            <h2 class='text-4xl font-bold mb-2'>Agregar Persona</h2>
            <form action="../controllers/TareaController.php" method='POST'>
                <input type="hidden" name="tareaxpersona" value='<?php echo $tarea; ?>'>
                <div class="mb-4">
                    <label for="persona" class="block text-gray-700 text-sm font-bold mb-2 text-left">Selecciona una persona para agregar:</label>
                    <select name="persona" id="persona" class="block w-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <?php foreach($listado_personas as $persona) { ?>
                            <option value=<?php echo $persona['id']; ?>><?php echo $persona['nombre']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="duracion" class="block text-gray-700 text-sm font-bold mb-2 text-left">Duración en Horas para Tarea:</label>
                    <input name="duracion" id="duracion" type="number" min="1" max="8" class="block w-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                </div>

                <?php if ($stmtPersonas->rowCount() > 0) { ?>
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Enviar
                    </button>
                <?php } ?>
            </form>
        </div>
    </div>  

    <!--Formulario para Recursos-->
    <div class='bg-white rounded-lg shadow-lg overflow-hidden'>
        <div class='p-6'>
            <h2 class='text-4xl font-bold mb-2'>Agregar Recurso</h2>
            <form action="../controllers/TareaController.php" method='POST'>
                <input type="hidden" name="tareaxrecurso" value='<?php echo $tarea; ?>'>
                <div class="mb-4">
                    <label for="recurso" class="block text-gray-700 text-sm font-bold mb-2 text-left">Selecciona un recurso para agregar:</label>
                    <select name="recurso" id="recurso" class="block w-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <?php foreach($listado_recursos as $recurso) { ?>
                            <option value=<?php echo $recurso['id']; ?>><?php echo $recurso['descripcion']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="cantidad" class="block text-gray-700 text-sm font-bold mb-2 text-left">Cantidad:</label>
                    <input name="cantidad" id="cantidad" type="number" min="1" class="block w-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                </div>

                <?php if ($stmtRecursos->rowCount() > 0) { ?>
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Enviar
                    </button>
                <?php } ?>
            </form>
        </div>
    </div>  

    <!-- Personas Registradas en la Tarea-->
    <div class='bg-white rounded-lg shadow-lg overflow-hidden mb-5'>
        <div class='p-6'>
            <h2 class='text-4xl font-bold mb-2'>Personas Inscritas en la Tarea</h2>
            <table class="min-w-full divide-y divide-gray-200 text-center">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre y Apellido</th>
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Identificación</th>
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección</th>
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach($personas_registradas as $persona) { ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $persona['nombre']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $persona['identificacion']; ?></td>                                
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $persona['direccion']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $persona['telefono']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div> 

    <!-- Recursos Registrados en la Tarea-->
    <div class='bg-white rounded-lg shadow-lg overflow-hidden mb-5'>
        <div class='p-6'>
            <h2 class='text-4xl font-bold mb-2'>Recursos dentro de la Tarea</h2>
            <table class="min-w-full divide-y divide-gray-200 text-center">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach($registros_tarea as $recurso) { ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $recurso['descripcion']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $recurso['cantidad']; ?></td>                                
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $recurso['total']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href="../index.php" class='mt-5 mb-5 mr-10 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline'>Volver al Proyecto</a>
</div>
</body>