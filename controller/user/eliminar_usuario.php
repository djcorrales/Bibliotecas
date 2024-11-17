<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/BIBLIOTECAS/config/conexion.php';

// Crear conexión a la base de datos
$conexion = (new Connection())->connect();

// Verificar si se recibe el ID del usuario y la contraseña
if (isset($_POST['eliminar']) && is_numeric($_POST['eliminar']) && isset($_POST['password'])) {
    $usuario_id = $_POST['eliminar'];
    $password = $_POST['password'];

    // Verificar si el usuario que está intentando eliminar es el mismo que está logueado
    if ($_SESSION['user_id'] == $usuario_id) {
        echo json_encode(['success' => false, 'message' => 'No puedes eliminar tu propio usuario. Tu sesión será cerrada.']);
        
        // Solo cerrar la sesión si el usuario intenta eliminar su cuenta
        session_destroy();
        exit;
    }

    // Consultar la contraseña del administrador
    $admin_query = "SELECT password FROM usuarios WHERE role_id = 1 LIMIT 1";
    $admin_stmt = $conexion->prepare($admin_query);
    $admin_stmt->execute();
    $admin = $admin_stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si la contraseña es correcta
    if ($admin && password_verify($password, $admin['password'])) {
        // Si la contraseña es correcta, proceder con la eliminación
        $delete_stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = :id");
        $delete_stmt->bindParam(':id', $usuario_id, PDO::PARAM_INT);

        if ($delete_stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Hubo un error al eliminar el usuario.']);
        }
    } else {
        // Contraseña incorrecta
        echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta.']);
    }
} else {
    // Faltan datos en el formulario
    echo json_encode(['success' => false, 'message' => 'Datos incompletos para eliminar el usuario.']);
}
