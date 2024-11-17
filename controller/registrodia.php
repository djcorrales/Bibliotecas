<?php
require_once '../config/conexion.php';

try {
    $connection = new Connection();
    $pdo = $connection->connect();

    // Obtener la cantidad de usuarios registrados hoy
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE DATE(fecha_registro) = CURDATE()");
    $stmt->execute();

    // Obtener el resultado
    $usuarios_registrados_hoy = $stmt->fetchColumn();
} catch (\Throwable $th) {
    echo "Error al obtener los usuarios registrados hoy: " . $th->getMessage();
}
?>
