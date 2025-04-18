<?php
// Este archivo permite iniciar sesión con usuario y contraseña
require 'db.php';

// Obtener datos del cuerpo del POST
$data = json_decode(file_get_contents("php://input"));

$username = $data->username ?? '';
$password = $data->password ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(["message" => "Usuario y contraseña requeridos."]);
    exit;
}

// Buscar usuario
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    echo json_encode(["message" => "Autenticación satisfactoria."]);
} else {
    echo json_encode(["message" => "Error en la autenticación."]);
}
?>
