<?php
// login_process.php
// Este script procesa el inicio de sesión y redirige al usuario.

session_start(); // Iniciar la sesión PHP

// Incluir el archivo de configuración de la base de datos
require_once 'db_config.php';

// Verificar si la solicitud es POST y si se enviaron los datos esperados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar la consulta SQL para buscar el usuario
    $sql = "SELECT id, username, password FROM usuarios WHERE username = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username); // Vincular el nombre de usuario

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // NOTA DE SEGURIDAD: En una aplicación real, usarías password_verify($password, $user['password'])
            if ($password === $user['password']) { // Comparación de contraseña en texto plano (solo para ejemplo)
                // Autenticación exitosa
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirigir a la página de bienvenida
                header('Location: bienvenido.php');
                exit;
            } else {
                // Contraseña incorrecta
                $_SESSION['login_error'] = 'Error en la autenticación: Usuario o contraseña incorrectos.';
                header('Location: index.php'); // Redirigir de vuelta al index con error
                exit;
            }
        } else {
            // Usuario no encontrado
            $_SESSION['login_error'] = 'Error en la autenticación: Usuario o contraseña incorrectos.';
            header('Location: index.php'); // Redirigir de vuelta al index con error
            exit;
        }

        $stmt->close();
    } else {
        // Error en la preparación de la declaración
        $_SESSION['login_error'] = 'Error interno del servidor al preparar la consulta.';
        header('Location: index.php');
        exit;
    }
} else {
    // Si no es una solicitud POST válida, redirigir al index
    header('Location: index.php');
    exit;
}

$conn->close(); // Cerrar la conexión
?>