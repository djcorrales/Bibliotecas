<?php
session_start();
require_once '../config/conexion.php';

// Verificar que el usuario es un administrador
if (!isset($_SESSION['username']) || $_SESSION['role_id'] != 1) {
    header("Location: ../index.php");
    exit();
}

try {
    $conexion = new Connection();
    $pdo = $conexion->connect();

    // Obtener todos los préstamos
    $stmt = $pdo->prepare("SELECT prestamos.id AS prestamo_id, libros.titulo, libros.autor, usuarios.nombre_completo, prestamos.fecha_prestamo, prestamos.fecha_devolucion, prestamos.estado
                           FROM prestamos
                           JOIN libros ON prestamos.libro_id = libros.id
                           JOIN usuarios ON prestamos.usuario_id = usuarios.id");
    $stmt->execute();
    $prestamos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $th) {
    $error = 'Error en la conexión: ' . $th->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Préstamos</title>
    <link rel="stylesheet" href="../public/css/quitar_libro.css">
</head>
<body>
    <div class="container">
        <h2>Gestión de Préstamos</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
<!-- Botón para descargar el PDF -->
<a href="../controller/generar_pdf.php" class="btn btn-primary">Descargar PDF</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID Préstamo</th>
                    <th>Libro</th>
                    <th>Autor</th>
                    <th>Estudiante</th>
                    <th>Fecha de Préstamo</th>
                    <th>Fecha de Devolución</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($prestamos) > 0): ?>
                    <?php foreach ($prestamos as $prestamo): ?>
                        <tr>
                            <td><?php echo $prestamo['prestamo_id']; ?></td>
                            <td><?php echo $prestamo['titulo']; ?></td>
                            <td><?php echo $prestamo['autor']; ?></td>
                            <td><?php echo $prestamo['nombre_completo']; ?></td>
                            <td><?php echo $prestamo['fecha_prestamo']; ?></td>
                            <td><?php echo $prestamo['fecha_devolucion'] ? $prestamo['fecha_devolucion'] : 'Pendiente'; ?></td>
                            <td><?php echo ucfirst($prestamo['estado']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No hay préstamos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
