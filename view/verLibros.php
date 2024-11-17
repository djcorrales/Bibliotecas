<?php
session_start();
require_once '../config/conexion.php'; // Incluye el archivo de conexión a la base de datos

// Inicializa la variable $books como un array vacío
$books = [];

try {
    // Realiza la consulta a la base de datos
    $conexion = (new Connection())->connect(); // Usa tu clase de conexión
    $stmt = $conexion->prepare("SELECT * FROM libros");
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtén todos los resultados en un array asociativo
} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error al obtener los libros: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Libros - Biblioteca Virtual</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="form-container">
    

    <?php
    // Mostrar mensaje si existe en la sesión
    if (isset($_SESSION['mensaje'])) {
        echo "<p class='mensaje-error'>{$_SESSION['mensaje']}</p>";
        unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
    }
    ?>

    <div>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                 
                </tr>
            </thead>
            <tbody id="tablaLibros">
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($book['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($book['autor']); ?></td>
                        <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                        <td><?php echo htmlspecialchars($book['categoria']); ?></td>
                        <td><?php echo htmlspecialchars($book['cantidad']); ?></td>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .mensaje-error {
        background-color: #dc3545;
        color: white;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-weight: bold;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

</body>
</html>
