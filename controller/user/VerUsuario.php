<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/BIBLIOTECAS/config/conexion.php';

try {
    // Conectar a la base de datos
    $conexion = (new Connection())->connect();

    // Consulta para obtener los usuarios con roles 1 (Administrador) y 2 (Usuario)
    $query = "SELECT id, username, nombre_completo, email, role_id FROM usuarios WHERE role_id IN (1, 2)";
    $stmt = $conexion->prepare($query);
    $stmt->execute();

    // Almacenar los usuarios en un array
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $usuarios = []; // Si hay un error, dejamos el array vacío
    error_log('Error al consultar usuarios: ' . $e->getMessage());
}

// Incluir la vista y pasarle los datos de usuarios
include($_SERVER['DOCUMENT_ROOT'] . '/BIBLIOTECAS/view/ver_User.php');
?>
