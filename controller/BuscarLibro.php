<?php
require_once '../config/conexion.php';
$connection = new Connection();
$pdo = $connection->connect();

$termino = $_GET['termino'] ?? '';

// Consulta para buscar libros por título, autor, ISBN o categoría
$sql = "SELECT id, titulo, autor, isbn, categoria, cantidad FROM libros 
        WHERE (titulo LIKE ? OR autor LIKE ? OR isbn LIKE ? OR categoria LIKE ?) 
        AND cantidad > 0";
$stmt = $pdo->prepare($sql);
$stmt->execute(['%' . $termino . '%', '%' . $termino . '%', '%' . $termino . '%', '%' . $termino . '%']);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generar el HTML de la tabla con los resultados de la búsqueda
foreach ($books as $book) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($book['titulo']) . "</td>";
    echo "<td>" . htmlspecialchars($book['autor']) . "</td>";
    echo "<td>" . htmlspecialchars($book['isbn']) . "</td>";
    echo "<td>" . htmlspecialchars($book['categoria']) . "</td>";
    echo "<td>" . htmlspecialchars($book['cantidad']) . "</td>";
    echo "<td><form class='prestar-form' data-libro-id='" . $book['id'] . "'><button type='submit' class='btn-prestar'>Prestar</button></form></td>";
    echo "</tr>";
}
?>
