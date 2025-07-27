<?php
// bienvenido.php
// Página de bienvenida accesible solo para usuarios autenticados.

session_start(); // Iniciar la sesión PHP

// Verificar si el usuario NO está logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php'); // Redirigir al index si no está logueado
    exit;
}

$username = $_SESSION['username']; // Obtener el nombre de usuario de la sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: "Inter", sans-serif; background-color: #f0f2f5; }
        .container { background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); padding: 2.5rem; margin: 2rem auto; max-width: 600px; width: 90%; text-align: center; }
        h1 { color: #333; margin-bottom: 1.5rem; font-size: 2.5rem; font-weight: 700; }
        p { font-size: 1.25rem; color: #4a5568; margin-bottom: 2rem; }
        .logout-button { padding: 0.75rem 1.5rem; background-color: #ef4444; color: white; border: none; border-radius: 0.5rem; font-size: 1.125rem; font-weight: 700; cursor: pointer; transition: background-color 0.3s ease; text-decoration: none; display: inline-block; }
        .logout-button:hover { background-color: #dc2626; }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4">
    <div class="container">
        <h1 class="text-4xl font-extrabold text-blue-800">¡Bienvenido, <?php echo htmlspecialchars($username); ?>!</h1>
        <p>Has iniciado sesión exitosamente en el sistema.</p>
        <a href="logout.php" class="logout-button">Cerrar Sesión</a>
    </div>
</body>
</html>
