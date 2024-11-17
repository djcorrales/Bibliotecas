<?php
session_start();
require_once '../config/conexion.php';

if (!isset($_SESSION['username']) || $_SESSION['role_id'] != 2) {
    header("Location: ../index.php");
    exit();
}

$response = []; // Para guardar el mensaje

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $libro_id = $_POST['libro_id'];
    $user_id = $_SESSION['user_id']; // El ID del usuario se asume que está en la sesión

    try {
        $conexion = new Connection();
        $pdo = $conexion->connect();

        // Verificar si el libro está disponible
        $stmt = $pdo->prepare("SELECT cantidad, isbn FROM libros WHERE id = ?");
        $stmt->execute([$libro_id]);
        $libro = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($libro) {
            // Verificar si el usuario ya ha prestado un libro con este ISBN
             // Verificar si el usuario ya ha prestado un libro con este ISBN y si el préstamo está activo
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM prestamos WHERE usuario_id = ? AND libro_id = ? AND estado = 'prestado'");
                $stmt->execute([$user_id, $libro_id]);
                $prestamos = $stmt->fetchColumn();

            if ($prestamos > 0) {
                $response['mensaje'] = "Ya has prestado este libro anteriormente.";
            } elseif ($libro['cantidad'] > 0) {
                // Registrar el préstamo
                $stmt = $pdo->prepare("INSERT INTO prestamos (usuario_id, libro_id, fecha_prestamo) VALUES (?, ?, NOW())");
                $stmt->execute([$user_id, $libro_id]);

                // Disminuir la cantidad del libro
                $stmt = $pdo->prepare("UPDATE libros SET cantidad = cantidad - 1 WHERE id = ?");
                $stmt->execute([$libro_id]);

                // Guardar mensaje en la respuesta
                $response['mensaje'] = "Libro prestado con éxito.";
            } else {
                $response['mensaje'] = "El libro no está disponible para préstamo.";
            }
        } else {
            $response['mensaje'] = "Libro no encontrado.";
        }
    } catch (Throwable $th) {
        $response['mensaje'] = 'Error en la conexión: ' . $th->getMessage();
    }
}

// Devolver la respuesta como JSON
echo json_encode($response);
exit();
?>
