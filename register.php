<?php
// Este archivo registra nuevos usuarios
require 'db.php';

// Obtener datos del cuerpo del POST
$data = json_decode(file_get_contents("php://input"));

$username = $data->username ?? '';
$password = $data->password ?? '';

// Validaciones básicas
if (empty($username) || empty($password)) {
    echo json_encode(["message" => "Usuario y contraseña requeridos."]);
    exit;
}

// Verificar si el usuario ya existe
$query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["message" => "El usuario ya existe."]);
    exit;
}

// Encriptar contraseña
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insertar nuevo usuario
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);
$stmt->execute();

echo json_encode(["message" => "Usuario registrado exitosamente."]);
?>
