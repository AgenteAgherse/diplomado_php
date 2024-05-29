<?php

session_start();
if (isset($_SESSION['email'])) {
    header('location: ./views/main.php');
}

$successMessage = "";
$errorMessage = "";
if (isset($_GET['registro'])) {
    $successMessage = "Registro exitoso.";
}
if (isset($_GET['error'])) {
    $errorMessage = "Error en las credenciales.";
}
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center">Iniciar Sesión</h2>
        <p class="text-center"><?php echo $successMessage; ?></p>
        <p class="text-center"><?php echo $errorMessage; ?></p>
        <form action="./controllers/PersonaController.php?inicio=true" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Iniciar Sesión
                </button>
            </div>
            <div class="mt-4 text-center">
                <a href="./views/registro.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Registrarse
                </a>
            </div>
        </form>
    </div>
</body>
</html>
