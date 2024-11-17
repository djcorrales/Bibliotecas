<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Solo inicia la sesión si no está activa
}
require_once '../config/conexion.php';

if (!isset($_SESSION['username']) || $_SESSION['role_id'] != 2) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id']; // El ID del usuario se asume que está en la sesión

// Obtener los préstamos del usuario, excluyendo los devueltos
try {
    $conexion = new Connection();
    $pdo = $conexion->connect();

    // Modificación para excluir los libros devueltos
    $stmt = $pdo->prepare("SELECT p.id, l.titulo, l.autor, p.fecha_prestamo 
                           FROM prestamos p 
                           JOIN libros l ON p.libro_id = l.id
                           WHERE p.usuario_id = ? AND p.estado != 'devuelto'"); // Se añade la condición de estado
    $stmt->execute([$user_id]);

    $prestamos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Throwable $th) {
    $_SESSION['mensaje'] = 'Error en la conexión: ' . $th->getMessage();
    header("Location: ../view/buscarLibro.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Préstamos</title>
    <link rel="stylesheet" href="../public/css/Misprestamos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Estilo para el modal */
        #modal-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); /* Centrado absoluto en la pantalla */
            width: 300px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            display: none; /* Inicialmente oculto */
            z-index: 9999;
            text-align: center;
        }

        /* Estilo para el contenido del modal */
        #modal-message p {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        /* Estilo del botón de cerrar */
        #modal-message button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }

        #modal-message button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="main-content">
    <h1>Mis Préstamos</h1>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <p class="mensaje"><?php echo htmlspecialchars($_SESSION['mensaje']); ?></p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <?php if ($prestamos): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Fecha de Préstamo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prestamos as $prestamo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($prestamo['id']); ?></td>
                        <td><?php echo htmlspecialchars($prestamo['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($prestamo['autor']); ?></td>
                        <td><?php echo htmlspecialchars($prestamo['fecha_prestamo']); ?></td>
                        <td>
                            <form class="devolver-form" data-prestamo-id="<?php echo $prestamo['id']; ?>" style="display:inline;">
                                <button type="submit">Devolver Libro</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes ningún préstamo.</p>
    <?php endif; ?>
</div>

<!-- Modal para mostrar el mensaje -->
<div id="modal-message">
    <p id="message-content"></p>
    <button onclick="closeModal()">Cerrar</button>
</div>

<script>
// Manejo de la petición AJAX
$('.devolver-form').on('submit', function(event) {
    event.preventDefault(); // Evitar el envío tradicional del formulario

    var prestamo_id = $(this).data('prestamo-id');
    var fila = $(this).closest('tr');  // Encuentra la fila correspondiente

    $.ajax({
        url: '../controller/DevolverLibro.php',
        type: 'POST',
        data: { prestamo_id: prestamo_id },
        success: function(response) {
            var result = JSON.parse(response);  // Convertir la respuesta JSON

            // Mostrar el mensaje en el modal
            $('#message-content').text(result.mensaje);
            $('#modal-message').fadeIn(); // Mostrar el modal con un efecto de desvanecimiento

            // Si el libro se ha devuelto correctamente, ocultar la fila en la vista
            fila.fadeOut(500);  // Ocultar la fila con un efecto de desvanecimiento
        },
        error: function() {
            alert('Hubo un error al procesar la solicitud.');
        }
    });
});

// Función para cerrar el modal
function closeModal() {
    $('#modal-message').fadeOut();  // Ocultar el modal con un efecto de desvanecimiento
    setTimeout(function() {
        location.reload();  // Recargar la página después de un pequeño retraso para que el modal se cierre correctamente
    }, 300); // Tiempo de espera para la transición
}
</script>

</body>
</html>
