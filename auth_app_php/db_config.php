<?php
// db_config.php
// Configuración de la conexión a la base de datos MySQL.

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // Contraseña de tu MySQL (vacío por defecto en XAMPP)
define('DB_NAME', 'Servidor'); // ¡Nombre de la base de datos: Servidor!

// Intentar establecer la conexión
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conn->set_charset("utf8mb4");
?>
