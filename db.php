<?php
// db.php - Conexión a la base de datos
$host = 'localhost';
$user = 'root';
$pass = 'Clave1234';
$dbname = 'auth_api';

$conn = new mysqli($host, $user, $pass, $dbname);

// Verifica si hay error de conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
