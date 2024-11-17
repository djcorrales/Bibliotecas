<?php
require('../libs/fpdf.php');
require_once '../config/conexion.php';

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, utf8_decode('Reporte de Préstamos y Devoluciones'), 0, 1, 'C');
        $this->Ln(10); // Salto de línea
        // Encabezado de la tabla
        $this->Cell(45, 10, utf8_decode('Libro'), 1, 0, 'C');
        $this->Cell(35, 10, utf8_decode('Autor'), 1, 0, 'C');
        $this->Cell(30, 10, utf8_decode('Estudiante'), 1, 0, 'C');
        $this->Cell(29, 10, utf8_decode('Fecha Préstamo'), 1, 0, 'C');
        $this->Cell(29, 10, utf8_decode('FechaDevolución'), 1, 0, 'C');
        $this->Cell(20, 10, utf8_decode('Estado'), 1, 1, 'C');
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
        // Derechos de autor
        $this->SetY(-10);
        $this->Cell(0, 10, 'Derechos de autor: Dainier Corrales', 0, 0, 'C');
    }
}

// Crear una instancia de la clase PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Conectar a la base de datos
try {
    $conexion = new Connection();
    $pdo = $conexion->connect();
    
    // Obtener todos los préstamos
    $stmt = $pdo->prepare("SELECT prestamos.id AS prestamo_id, libros.titulo, libros.autor, usuarios.nombre_completo,
                                     prestamos.fecha_prestamo, prestamos.fecha_devolucion, prestamos.estado
                           FROM prestamos
                           JOIN libros ON prestamos.libro_id = libros.id
                           JOIN usuarios ON prestamos.usuario_id = usuarios.id");
    $stmt->execute();
    $prestamos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Rellenar los datos de los préstamos
    foreach ($prestamos as $prestamo) {
        // Asegúrate de que los textos con acentos y ñ se muestren correctamente
        $titulo = utf8_decode($prestamo['titulo']);
        $autor = utf8_decode($prestamo['autor']);
        $nombre_estudiante = utf8_decode($prestamo['nombre_completo']);
        $fecha_prestamo = utf8_decode(date("d/m/Y", strtotime($prestamo['fecha_prestamo']))); // Mostrar fecha correctamente
        // Formatear la fecha de devolución, si está vacía mostrar "Pendiente"
        $fecha_devolucion = $prestamo['fecha_devolucion'] ? utf8_decode(date("d/m/Y", strtotime($prestamo['fecha_devolucion']))) : 'Pendiente';
        $estado = utf8_decode(ucfirst($prestamo['estado']));

        // Imprimir los datos en la tabla
        $pdf->Cell(45, 10, $titulo, 1, 0, 'C');
        $pdf->Cell(35, 10, $autor, 1, 0, 'C');
        $pdf->Cell(30, 10, $nombre_estudiante, 1, 0, 'C');
        $pdf->Cell(29, 10, $fecha_prestamo, 1, 0, 'C');
        $pdf->Cell(29, 10, $fecha_devolucion, 1, 0, 'C');
        $pdf->Cell(20, 10, $estado, 1, 1, 'C');
    }

} catch (Exception $e) {
    die('Error al obtener los datos: ' . $e->getMessage());
}

// Enviar el PDF al navegador para descarga
$pdf->Output('D', 'reporte_prestamos.pdf');  // 'D' indica que el archivo se descargará en lugar de abrirse
?>
