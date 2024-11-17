<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/BIBLIOTECAS/config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar los datos del formulario
    $username = $_POST['username'];
    $nombre_completo = $_POST['nombre_completo'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $role_id = $_POST['role_id'];

    // Conexión a la base de datos
    $conexion = (new Connection())->connect();

    // Verificar si el nombre de usuario ya existe
    $query_usuario = "SELECT COUNT(*) FROM usuarios WHERE username = :username";
    $stmt_usuario = $conexion->prepare($query_usuario);
    $stmt_usuario->bindParam(':username', $username);
    $stmt_usuario->execute();
    $existe_usuario = $stmt_usuario->fetchColumn();

    if ($existe_usuario > 0) {
        echo json_encode(["status" => "error", "message" => "El nombre de usuario ya existe."]);
        exit;
    }

    // Verificar si el correo electrónico ya existe
    $query_email = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
    $stmt_email = $conexion->prepare($query_email);
    $stmt_email->bindParam(':email', $email);
    $stmt_email->execute();
    $existe_email = $stmt_email->fetchColumn();

    if ($existe_email > 0) {
        echo json_encode(["status" => "error", "message" => "El correo electrónico ya está registrado."]);
        exit;
    }

    // Cifrar la contraseña
    $contraseña_cifrada = password_hash($contraseña, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    $query_insertar = "INSERT INTO usuarios (username, nombre_completo, email, password, role_id) 
                       VALUES (:username, :nombre_completo, :email, :password, :role_id)";
    $stmt_insertar = $conexion->prepare($query_insertar);
    $stmt_insertar->bindParam(':username', $username);
    $stmt_insertar->bindParam(':nombre_completo', $nombre_completo);
    $stmt_insertar->bindParam(':email', $email);
    $stmt_insertar->bindParam(':password', $contraseña_cifrada);
    $stmt_insertar->bindParam(':role_id', $role_id);

    if ($stmt_insertar->execute()) {
        echo json_encode(["status" => "success", "message" => "Usuario agregado exitosamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al agregar el usuario."]);
    }
    exit;
}
?>
