<?php
session_start();

$email = isset($_SESSION['email'])? $_SESSION['email']: null;
if ($email == null) { 
    header('location: ../index.php');
}

require_once('../database/db.php');

$db = conectar();
$sql = "SELECT * FROM proyectos WHERE responsable = (SELECT id_persona FROM personas WHERE email = '$email')";
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        function abrirModalProyecto() {
            document.getElementById('modalProyecto').classList.remove('hidden');
        }

        function cerrarModalProyecto() {
            document.getElementById('modalProyecto').classList.add('hidden');
        }

        function abrirModalPersonas() {
            document.getElementById('modalPersonas').classList.remove('hidden');
        }

        function cerrarModalPersonas() {
            document.getElementById('modalPersonas').classList.add('hidden');
        }
        function abrirModalRecursos() {
            document.getElementById('modalRecursos').classList.remove('hidden');
        }

        function cerrarModalRecursos() {
            document.getElementById('modalRecursos').classList.add('hidden');
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8 text-center">
        <h1 class="text-3xl font-bold mb-8 text-center">Proyectos del Usuario</h1>
        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2">
            <!-- Carta 1 -->
            <?php
            foreach ($results as $proyecto) {
                echo "<div class='bg-white rounded-lg shadow-lg overflow-hidden'>
                        <div class='p-6'>
                            <h2 class='text-xl font-bold mb-2'>".$proyecto['titulo']."</h2>
                            <p class='text-gray-700'>".$proyecto['Descripcion']."</p>";
                

                if ($proyecto['Estado'] === 'En Curso') {
                    echo "<p>Estado: <span class='bg-yellow-400 text-white rounded-full px-2 py-1'>En Curso</span></p>";
                }
                else if ($proyecto['Estado'] === 'Proximamente') {
                    echo "<p>Estado: <span class='bg-blue-500 text-white rounded-full px-2 py-1'>Próximamente</span></p>";
                }
                else if ($proyecto['Estado'] === 'No cumplido') {
                    echo "<p>Estado: <span class='bg-red-400 text-white rounded-full px-2 py-1'>No Cumplido</span></p>";
                }
                else {
                    echo "<p>Estado: <span class='bg-green-400 text-white rounded-full px-2 py-1'>Finalizado</span></p>";
                }

                echo "<br>";
                echo "
                    <a href='./proyecto.php?proyecto=".$proyecto['Id_proyecto']."' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline' type='submit'>
                        Entrar
                    </a>";

                echo "</div>
                    </div>";
            }
            ?>
        </div>
    </div>

    <div class="text-center mr-5">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="abrirModalProyecto()">
            Agregar Proyecto
        </button>
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="abrirModalPersonas()">
            Agregar Personas
        </button>
        <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="abrirModalRecursos()">
            Agregar Recursos
        </button>
        <form action="../controllers/SesionController.php" method='POST' class="text-center">
            <input type="hidden" name="logout">
            <button class="mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type='submit'>
                Salir
            </button>
        </form>
    </div>

    



















    <!-- Modal -->
    <div id="modalProyecto" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-2xl font-bold mb-4">Crear Nuevo Proyecto</h2>
            <form action="../controllers/ProyectoController.php"  method="POST">
                <div class="mb-4">
                    <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título del Proyecto</label>
                    <input type="text" id="titulo" name="titulo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="descripcion" class="block text-gray-700 text-sm font-bold mb-2">Descripción del Proyecto</label>
                    <input type="text" id="descripcion" name="descripcion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="fecha_inicio" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Inicio</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="fecha_entrega" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Entrega</label>
                    <input type="date" id="fecha_entrega" name="fecha_entrega" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="valor" class="block text-gray-700 text-sm font-bold mb-2">Valor del Proyecto</label>
                    <input type="number" id="valor" name="valor" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="lugar" class="block text-gray-700 text-sm font-bold mb-2">Lugar</label>
                    <input type="text" id="lugar" name="lugar" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex items-center justify-between">
                    <button type="button" onclick="cerrarModalProyecto()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>




    <!--MODAL PERSONAS-->
    <div id="modalPersonas" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-2xl font-bold mb-4">Agregar Nuevas Personas</h2>
            <form action="../controllers/PersonaController.php?personal=true"  method="POST">
                <div class="mb-4">
                    <label for="identificacion" class="block text-gray-700 text-sm font-bold mb-2">Identificación</label>
                    <input type="text" id="identificacion" name="identificacion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="apellido" class="block text-gray-700 text-sm font-bold mb-2">Apellidos</label>
                    <input type="text" id="apellido" name="apellidos" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="direccion" class="block text-gray-700 text-sm font-bold mb-2">Dirección</label>
                    <input type="text" id="direccion" name="direccion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="telefono" class="block text-gray-700 text-sm font-bold mb-2">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="sexo" class="block text-gray-700 text-sm font-bold mb-2">Sexo</label>
                    <select id="sexo" name="sexo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="" disabled selected>Selecciona tu sexo</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="fechaNacimiento" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Nacimiento</label>
                    <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="profesion" class="block text-gray-700 text-sm font-bold mb-2">Profesion</label>
                    <input type="text" id="profesion" name="profesion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex items-center justify-between">
                    <button type="button" onclick="cerrarModalPersonas()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>



    <!--MODAL RECURSOS-->
    <div id="modalRecursos" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-2xl font-bold mb-4">Agregar Nuevo Recurso</h2>
            <form action="../controllers/RecursosController.php"  method="POST">
                <div class="mb-4">
                    <label for="descripcion" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                    <input type="text" id="descripcion" name="descripcion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="valor" class="block text-gray-700 text-sm font-bold mb-2">Valor</label>
                    <input type="number" min="0" id="valor" name="valor" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="unidad" class="block text-gray-700 text-sm font-bold mb-2">Unidad de Medida</label>
                    <input type="text" id="unidad" name="unidad" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                
                <div class="flex items-center justify-between">
                    <button type="button" onclick="cerrarModalRecursos()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
