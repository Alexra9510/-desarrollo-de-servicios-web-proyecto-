<?php
// registro.php
// Página con formulario para registrar nuevos usuarios.

session_start(); // Iniciar la sesión PHP

$register_error = '';

// Verificar si hay un mensaje de error de registro en la sesión
if (isset($_SESSION['register_error'])) {
    $register_error = $_SESSION['register_error'];
    unset($_SESSION['register_error']); // Limpiar el mensaje después de mostrarlo
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: "Inter", sans-serif; background-color: #f0f2f5; }
        .container { background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); padding: 2.5rem; margin: 2rem auto; max-width: 450px; width: 90%; text-align: center; }
        h1 { color: #333; margin-bottom: 1.5rem; font-size: 2.25rem; font-weight: 700; }
        .form-group { margin-bottom: 1rem; text-align: left; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #4a5568; }
        input[type="text"], input[type="password"] { width: 100%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.5rem; box-sizing: border-box; font-size: 1rem; }
        button { width: 100%; padding: 0.75rem; background-color: #4299e1; color: white; border: none; border-radius: 0.5rem; font-size: 1.125rem; font-weight: 700; cursor: pointer; transition: background-color 0.3s ease; }
        button:hover { background-color: #2b6cb0; }
        .message { margin-top: 1.5rem; padding: 1rem; border-radius: 0.5rem; font-weight: 600; }
        .error { background-color: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }
        .link-login { display: block; margin-top: 1.5rem; color: #4299e1; text-decoration: none; font-weight: 600; }
        .link-login:hover { text-decoration: underline; }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4">
    <div class="container">
        <h1 class="text-4xl font-extrabold text-green-700">Registrar Nuevo Usuario</h1>

        <?php if (!empty($register_error)): ?>
            <div class="message error mb-4">
                <?php echo $register_error; ?>
            </div>
        <?php endif; ?>

        <form action="register_process.php" method="POST" class="space-y-4">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white">Registrar</button>
        </form>

        <a href="index.php" class="link-login">Volver a Iniciar Sesión</a>
    </div>
</body>
</html>