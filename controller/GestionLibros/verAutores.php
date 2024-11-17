<?php
session_start();

// Incluye la conexión a la base de datos
require_once $_SERVER['DOCUMENT_ROOT'] . '/BIBLIOTECA/config/conexion.php';

// Conectar a la base de datos
$conexion = (new Connection())->connect();

// Realiza la consulta para obtener los autores únicos
$query = "SELECT DISTINCT autor FROM libros";
$stmt = $conexion->prepare($query);
$stmt->execute();

// Verifica si se obtuvieron autores
$autores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pasar los autores a la vista para que los muestre
include "../view/verAutores.php";
?>
