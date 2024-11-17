<?php
session_start();
require_once '../config/conexion.php';

if (!isset($_SESSION['username']) || $_SESSION['role_id'] != 2) {
    header("Location: ../index.php");
    exit();
}

$response = []; // Para guardar el mensaje

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prestamo_id = $_POST['prestamo_id'];

    try {
        $conexion = new Connection();
        $pdo = $conexion->connect();

        // Verificar que el préstamo existe
        $stmt = $pdo->prepare("SELECT libro_id FROM prestamos WHERE id = ?");
        $stmt->execute([$prestamo_id]);
        $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($prestamo) {
            $libro_id = $prestamo['libro_id'];

            // Cambiar el estado del préstamo a 'devuelto' y agregar la fecha de devolución
            $stmt = $pdo->prepare("UPDATE prestamos 
                                   SET estado = 'devuelto', fecha_devolucion = NOW() 
                                   WHERE id = ?");
            $stmt->execute([$prestamo_id]);

            // Aumentar la cantidad del libro disponible en la base de datos
            $stmt = $pdo->prepare("UPDATE libros SET cantidad = cantidad + 1 WHERE id = ?");
            $stmt->execute([$libro_id]);

            $response['mensaje'] = "Libro devuelto con éxito.";
        } else {
            $response['mensaje'] = "No se encontró el préstamo.";
        }
    } catch (Throwable $th) {
        $response['mensaje'] = 'Error en la conexión: ' . $th->getMessage();
    }
}

// Devolver la respuesta como JSON
echo json_encode($response);
exit();
