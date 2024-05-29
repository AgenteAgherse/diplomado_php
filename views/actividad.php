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
    if ($proyecto == null || $actividad == null) {
        header('location: ./main.php');
        exit();
    }

    $db = conectar();
    $stmt = $db->prepare(Tarea::listarTareas($actividad));
    $stmt->execute();
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC); // listado de tareas.

    $stmt = $db->prepare("SELECT presupuesto-(SELECT SUM(presupuesto) FROM tareas WHERE id_actividad = :id) AS presupuesto_disponible FROM actividades WHERE id_actividad = :id");
    $stmt->bindParam(':id', $actividad);
    $stmt->execute();
    $presupuesto = $stmt->fetch(PDO::FETCH_ASSOC); // presupuesto disponible.
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
<body class="bg-red-100">
    <div class=" text-center ml-20 mr-20 mt-10 grid gap-6 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
        <!-- Sección de Actividades -->
        <div class='bg-white rounded-lg shadow-lg overflow-hidden'>
            <div class='p-6'>
                <h2 class='text-4xl font-bold mb-2'>Tareas</h2>


                <!--Generación de Actividades-->
                <?php foreach($tareas as $act) {?>
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
                            <section class="mt-3 mr-4">
                                <a href='./tarea.php?proyecto=<?php echo $proyecto;?>&actividad=<?php echo $act['Id_actividad'];?>&tarea=<?php echo $act['Id_tarea']?>' class="block w-full bg-green-500 hover:bg-green-700 text-white text-center py-2 mt-2">
                                    Gestionar
                                </a>
                                <a href='../controllers/TareaController.php?proyecto=<?php echo $proyecto;?>&actividad=<?php echo $act['Id_actividad'];?>&tarea=<?php echo $act['Id_tarea']; ?>' class="block w-full bg-blue-500 hover:bg-blue-700 text-white text-center py-2 mb-2">
                                    Finalizar
                                </a>
                            </section>
                        <?php }?>
                    </div>
                <?php }?>
                <button class='mt-8 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline' onclick="abrirModalTareas()">Agregar Tarea</button>
            </div>
        </div>


        <a href="./proyecto.php?proyecto=<?php echo $proyecto; ?>" class='mt-5 mb-5 mr-10 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline'>Volver al Proyecto</a>
    </div>




    <!-- Modal Actividades -->
    <div id="modalTareas" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-2xl font-bold mb-4">Crear Nueva Tarea</h2>
            <form action="../controllers/TareaController.php"  method="POST">
                <input type="hidden" name="actividad" value="<?php echo $actividad; ?>">
                <input type="hidden" name="proyecto" value="<?php echo $proyecto; ?>">
                <div class="mb-4">
                    <label for="descripcion" class="block text-gray-700 text-sm font-bold mb-2">Descripción de la Tarea</label>
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
                    <label for="presupuesto" class="block text-gray-700 text-sm font-bold mb-2">Presupuesto de la Tarea</label>
                    <input type="number" min="0" max="<?php echo $presupuesto['presupuesto_disponible']; ?>" id="presupuesto" name="presupuesto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex items-center justify-between">
                    <button type="button" onclick="cerrarModalTareas()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
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