<?php

session_start();
if (isset($_SESSION['email'])) {
    header('location: main.php');
}

$errorMessage = "";
if (isset($_GET['error'])) {
    $errorMessage = "Correo registrado anteriormente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center text-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Registrarse</h2>
        <form action="../controllers/PersonaController.php?registro=true" method="POST">
            <div class="mb-4">
                <label for="identificacion" class="block text-gray-700 text-sm font-bold mb-2">Identificación</label>
                <input type="text" id="identificacion" name="identificacion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="correo" class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico</label>
                <input type="text" id="correo" name="correo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <p><?php echo $errorMessage; ?></p>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="apellidos" class="block text-gray-700 text-sm font-bold mb-2">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="direccion" class="block text-gray-700 text-sm font-bold mb-2">Dirección</label>
                <input type="text" id="direccion" name="direccion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="telefono" class="block text-gray-700 text-sm font-bold mb-2">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
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
            <div class="mb-6">
                <label for="profesion" class="block text-gray-700 text-sm font-bold mb-2">Profesión</label>
                <input type="text" id="profesion" name="profesion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Registrarse
                </button>
            </div>
            <div class="mt-4 text-center">
                <a href="../index.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Volver a Inicio
                </a>
            </div>
        </form>
    </div>
</body>
</html>
