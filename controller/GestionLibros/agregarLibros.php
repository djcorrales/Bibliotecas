<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Bibliotecas/config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $isbn = $_POST['isbn'];
    $fecha_publicacion = $_POST['fecha_publicacion'];
    $categoria = $_POST['categoria'];
    $cantidad = $_POST['cantidad'];

    $conexion = (new Connection())->connect();

    // Verificar si el ISBN ya existe
    $query = "SELECT COUNT(*) FROM libros WHERE isbn = :isbn";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':isbn', $isbn);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "El ISBN ya está registrado. Por favor, ingrese un ISBN único.";
    } else {
        $query = "INSERT INTO libros (titulo, autor, isbn, fecha_publicacion, categoria, cantidad) 
                  VALUES (:titulo, :autor, :isbn, :fecha_publicacion, :categoria, :cantidad)";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':isbn', $isbn);
        $stmt->bindParam(':fecha_publicacion', $fecha_publicacion);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':cantidad', $cantidad);

        if ($stmt->execute()) {
            echo "Libro agregado exitosamente.";
        } else {
            echo "Error al agregar el libro. Inténtelo de nuevo.";
        }
    }
} else {
    echo "El formulario no se ha enviado correctamente.";
}
