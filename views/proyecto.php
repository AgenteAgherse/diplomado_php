<?php
require('../models/Actividad.php');
require_once('../database/db.php');

session_start();

$email = isset($_SESSION['email'])? $_SESSION['email']: null;
if ($email == null) { 
    header('location: ./main.php');
    exit();
}

$proyecto = isset($_GET['proyecto'])? $_GET['proyecto']: null;
if ($proyecto == null) {
    header('location: ./main.php');
    exit();
}

$db = conectar();
$stmt = $db->prepare(Actividad::listar($proyecto));
$stmt->execute();
$actividades = $stmt->fetchAll(PDO::FETCH_ASSOC); // listado de actividades.


$stmt = $db->prepare("CALL progreso_actividad($proyecto)");
$stmt->execute();
$progreso = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $db->prepare("CALL progreso_actividad($proyecto)");
$stmt->execute();
$progreso = $stmt->fetch(PDO::FETCH_ASSOC); // Progreso de la actividad.

$stmt = $db->prepare("CALL presupuesto_gastado($proyecto)");
$stmt->execute();
$presupuesto_gastado = $stmt->fetch(PDO::FETCH_ASSOC); // Presupuesto Gastado

$stmt = $db->prepare("SELECT estado FROM proyectos WHERE id_proyecto = $proyecto");
$stmt->execute();
$estado_proyecto = $stmt->fetch(PDO::FETCH_ASSOC); // Estado del Proyecto.

$sql = "SELECT tareas.descripcion, CONCAT(personas.nombre, ' ', personas.apellidos) AS nombre, personas.identificacion AS identificacion, personas.direccion AS direccion, personas.telefono AS telefono FROM tareas
        JOIN tareaxpersona ON tareas.id_tarea = tareaxpersona.id_tarea
        JOIN actividades ON actividades.id_actividad = tareas.id_actividad
        JOIN proyectos ON proyectos.id_proyecto = actividades.id_proyecto
        JOIN personas ON tareaxpersona.id_persona = personas.id_persona
        WHERE proyectos.id_proyecto = $proyecto";
$stmt = $db->prepare($sql);
$stmt->execute();
$personas_inscritas = $stmt->fetchAll(PDO::FETCH_ASSOC); // Personas Inscritas al Proyecto

$sql = "SELECT DISTINCT(recursos.id_recurso), recursos.descripcion AS nombre, tareaxrecurso.cantidad AS cantidad, recursos.valor as valor, (tareaxrecurso.cantidad * recursos.valor) AS total, tareas.descripcion AS tarea FROM tareaxrecurso
            JOIN tareas ON tareas.id_tarea = tareaxrecurso.id_tarea
            JOIN actividades ON tareas.id_actividad = actividades.id_actividad
            JOIN proyectos ON proyectos.id_proyecto = actividades.id_proyecto
            JOIN recursos ON tareaxrecurso.id_recurso = recursos.id_recurso
        WHERE proyectos.id_proyecto = $proyecto";
$stmt = $db->prepare($sql);
$stmt->execute();
$recursos_inscritos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recursos usados en el proyecto.
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
        function abrirModalActividades() {
            document.getElementById('modalActividades').classList.remove('hidden');
        }

        function cerrarModalActividades() {
            document.getElementById('modalActividades').classList.add('hidden');
        }

        function abrirModalPersonas() {
            document.getElementById('modalPersonas').classList.remove('hidden');
        }

        function cerrarModalPersonas() {
            document.getElementById('modalPersonas').classList.add('hidden');
        }
    </script>
</head>
<body class="bg-red-100">
    <div class=" text-center ml-20 mr-20 mt-10 grid gap-6 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
        <!-- Sección de Actividades -->
        <div class='bg-white rounded-lg shadow-lg overflow-hidden'>
            <div class='p-6'>
                <h2 class='text-4xl font-bold mb-2'>Actividades</h2>


                <!--Generación de Actividades-->
                <?php foreach($actividades as $act) {?>
                    <div class="bg-gray-100 rounded-lg shadow-lg mt-5 text-center ml-20 mr-20 mt-10 grid gap-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2">
                        <section class="ml-2 text-left b-1 mb-5">
                            <p class="text-l ml-2 mt-2 mb-5"><strong>Descripción: </strong><?php echo $act['Descripcion'];?></p>
                            <p class="text-m ml-2 mt-2 mb-5"><strong>Presupuesto: </strong>$<?php echo $act['Presupuesto'];?>COP</p>
                            <?php
                            if ($act['Estado'] === 'En Curso') {
                                echo "<p class='text-center'>Estado: <span class='bg-yellow-400 text-white rounded-full px-2 py-1'>En Curso</span></p>";
                            }
                            else if ($act['Estado'] === 'Proximamente') {
                                echo "<p class='text-center'>Estado: <span class='bg-blue-500 text-white rounded-full px-2 py-1'>Próximamente</span></p>";
                            }
                            else if ($act['Estado'] === 'No cumplido') {
                                echo "<p class='text-center'>Estado: <span class='bg-red-400 text-white rounded-full px-2 py-1'>No Cumplido</span></p>";
                            }
                            else {
                                echo "<p class='text-center'>Estado: <span class='bg-green-400 text-white rounded-full px-2 py-1'>Finalizado</span></p>";
                            }
                            ?>
                        </section>
                        <?php if ($act['Estado'] != 'Finalizado') {?>
                        <section>
                            <a href='./actividad.php?proyecto=<?php echo $proyecto;?>&actividad=<?php echo $act['Id_actividad'];?>' class="block w-full bg-green-500 hover:bg-green-700 text-white text-center py-2">
                                Gestionar
                            </a>
                            <a href='../controllers/ActividadController.php?actividad=<?php echo $act['Id_actividad'];?>' class="block w-full bg-blue-500 hover:bg-blue-700 text-white text-center py-2">
                                Finalizar Actividad
                            </a>
                        </section>
                        <?php }?>
                    </div>
                <?php }?>
                <?php if ($estado_proyecto['estado'] != 'Finalizado') {?>
                    <button class='mt-8 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline' onclick="abrirModalActividades()">Agregar Actividad</button>
                <?php }?>

                
            </div>
        </div>


        <!--Sección de Recursos-->
        <div class='bg-white rounded-lg shadow-lg overflow-hidden'>
            <div class='p-6'>
                <h2 class='text-4xl font-bold mb-2'>Recursos Usados</h2>
                <table class="min-w-full divide-y divide-gray-200 text-center">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Tarea</th>
                            <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                            <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                            <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                            <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach($recursos_inscritos as $recurso) { ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $recurso['tarea']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $recurso['nombre']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $recurso['cantidad']; ?></td>                                
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $recurso['valor']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $recurso['total']; ?></td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
            </div>
        </div>


        <!-- Sección de Personas Listadas -->
        <div class='bg-white rounded-lg shadow-lg overflow-hidden'>
            <div class='p-6'>
                <h2 class='text-4xl font-bold mb-2'>Personas Inscritas en el Proyecto</h2>
                <table class="min-w-full divide-y divide-gray-200 text-center">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Tarea</th>
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre y Apellido</th>
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Identificación</th>
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección</th>
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach($personas_inscritas as $persona) { ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $persona['descripcion']; ?></td>
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


        <div class='bg-white rounded-lg shadow-lg overflow-hidden'>
            <div class='p-6'>
                <h2 class='text-4xl font-bold mb-2'>Datos del Proyecto</h2>
                <section class="mt-5">
                    <h3 class="text-left">Progreso del Proyecto</h3>
                    <div class='bg-green-400 h-6 rounded-full text-gray-500' style='width:<?php echo $progreso['progreso']; ?>%;'><?php echo $progreso['progreso']; ?>%</div>
                </section>
                <section class="mt-5">
                    <h3 class="text-left">Presupuesto Gastado: $ <?php echo $presupuesto_gastado['gastado'];?>COP</h3>
                </section>
                <?php if ($progreso['progreso'] == 100 && $estado_proyecto['estado'] != 'Finalizado'){?>
                    <section class="mt-5">
                        <a href="../controllers/ProyectoController.php?proyecto=<?php echo $proyecto; ?>" class='mt-5 mb-5 mr-10 w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline'>Finalizar Proyecto</a>
                    </section>
                <?php }?>
            </div>
        </div>
        


        <a href="./main.php" class='mt-5 mb-5 mr-10 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline'>Volver a Inicio</a>
    </div>




    <!-- Modal Actividades -->
    <div id="modalActividades" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-2xl font-bold mb-4">Crear Nueva Actividad</h2>
            <form action="../controllers/ActividadController.php"  method="POST">
                <input type="hidden" name="id_proyecto" value="<?php echo $proyecto; ?>">
                <div class="mb-4">
                    <label for="descripcion" class="block text-gray-700 text-sm font-bold mb-2">Descripción de la Actividad</label>
                    <input type="text" id="descripcion" name="descripcion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="fecha_inicio" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Inicio</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="fecha_final" class="block text-gray-700 text-sm font-bold mb-2">Fecha Finalización</label>
                    <input type="date" id="fecha_final" name="fecha_final" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="presupuesto" class="block text-gray-700 text-sm font-bold mb-2">Presupuesto de la Actividad</label>
                    <input type="number" min="0" id="presupuesto" name="presupuesto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex items-center justify-between">
                    <button type="button" onclick="cerrarModalActividades()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>