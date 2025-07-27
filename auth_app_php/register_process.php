<?php
// register_process.php
// Este script procesa el registro de nuevos usuarios.

session_start(); // Iniciar la sesión PHP para manejar mensajes de error/éxito

// Incluir el archivo de configuración de la base de datos
require_once 'db_config.php';

// Verificar si la solicitud es de tipo POST y si se han enviado los datos de usuario y contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar que los campos no estén vacíos
    if (empty($username) || empty($password)) {
        $_SESSION['register_error'] = 'Usuario y contraseña son requeridos.';
        header('Location: registro.php');
        exit;
    }

    // NOTA DE SEGURIDAD CRÍTICA:
    // En una aplicación real y segura, aquí se HASHEA la contraseña antes de guardarla.
    // Ejemplo: $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Para este ejemplo, la almacenaremos en texto plano (NO SEGURO PARA PRODUCCIÓN).
    $hashed_password = $password; // Usando la contraseña en texto plano para este ejemplo

    // Paso 1: Verificar si el nombre de usuario ya existe ANTES de intentar insertar
    $check_sql = "SELECT id FROM usuarios WHERE username = ?";
    if ($check_stmt = $conn->prepare($check_sql)) {
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_stmt->store_result(); // Almacenar el resultado para poder usar num_rows

        if ($check_stmt->num_rows > 0) {
            // Si num_rows es mayor que 0, el usuario ya existe
            $_SESSION['register_error'] = 'El usuario "' . htmlspecialchars($username) . '" ya se encuentra registrado. Por favor, elige otro.';
            $check_stmt->close();
            $conn->close();
            header('Location: registro.php');
            exit;
        }
        $check_stmt->close();
    } else {
        // Error en la preparación de la declaración de verificación
        $_SESSION['register_error'] = 'Error interno del servidor al verificar el usuario.';
        $conn->close();
        header('Location: registro.php');
        exit;
    }


    // Paso 2: Si el usuario no existe, proceder con la inserción
    $insert_sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";

    if ($stmt = $conn->prepare($insert_sql)) {
        // Vincular los parámetros a la declaración preparada (ss = dos strings)
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            // Registro exitoso: Almacenar mensaje de éxito en la sesión y redirigir al index
            $_SESSION['register_success'] = '¡Registro exitoso! Ahora puedes iniciar sesión.';
            header('Location: index.php');
            exit;
        } else {
            // Este bloque maneja otros posibles errores de la base de datos durante la inserción
            // Aunque ya verificamos la existencia, otros errores (ej. de conexión) podrían ocurrir.
            $_SESSION['register_error'] = 'Error al registrar el usuario: ' . $stmt->error;
            header('Location: registro.php'); // Redirigir de vuelta al formulario de registro con el error
            exit;
        }

        $stmt->close(); // Cerrar la declaración preparada
    } else {
        // Error en la preparación de la declaración SQL de inserción
        $_SESSION['register_error'] = 'Error interno del servidor al preparar la consulta de registro.';
        header('Location: registro.php');
        exit;
    }
} else {
    // Si la solicitud no es POST o faltan datos, redirigir al formulario de registro
    header('Location: registro.php');
    exit;
}

$conn->close(); // Cerrar la conexión a la base de datos
?>