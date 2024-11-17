<?php

// Verifica si el usuario está autenticado y tiene el rol de usuario sin permisos de administrador (rol_id = 2)
if (!isset($_SESSION['username']) || $_SESSION['role_id'] != 2) {
    header("Location: ../index.php");
    exit();
}

// Conectar a la base de datos
require_once '../config/conexion.php';
$connection = new Connection();
$pdo = $connection->connect();

// Obtener la lista de libros disponibles, incluyendo la categoría
$sql = "SELECT id, titulo, autor, isbn, categoria, cantidad FROM libros WHERE cantidad > 0";
$stmt = $pdo->query($sql);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="../public/css/dash_usuario.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <!-- Contenedor de la ventana modal -->
    <div id="modal-message">
    <p id="message-content"></p>
    <button onclick="closeModal()">Cerrar</button>
    </div>

    <div class="book-list">
        <h3>Tu aventura literaria comienza aquí: Bienvenido a tu biblioteca virtual.</h3>
        <br>
    </div>

    <div class="book-list">
        <h2>Libros Disponibles</h2>
        
        <!-- Campo de búsqueda -->
        <input type="text" id="buscarLibro" placeholder="Buscar libro...">
        <br><br>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>ISBN</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Acción</th>
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
                            <td>
                                <form class="prestar-form" data-libro-id="<?php echo $book['id']; ?>">
                                    <button type="submit" class="btn-prestar">Prestar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Función de búsqueda en tiempo real
        $('#buscarLibro').on('keyup', function() {
            var termino = $(this).val();

            $.ajax({
                url: '../controller/BuscarLibro.php',
                type: 'GET',
                data: { termino: termino },
                success: function(response) {
                    $('#tablaLibros').html(response);
                }
            });
        });

        // Script para el préstamo de libros
        $(document).on('submit', '.prestar-form', function(event) {
            event.preventDefault();
            var libro_id = $(this).data('libro-id');
            
            $.ajax({
                url: '../controller/prestarLibro.php',
                type: 'POST',
                data: { libro_id: libro_id },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.mensaje) {
                        $('#message-content').text(result.mensaje);
                        $('#modal-message').show(); // Mostrar la ventana modal
                    }
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

    
   <!-- CSS para la ventana modal -->
<style>
    /* Estilo para el modal */
    #modal-message {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); /* Centrado absoluto en la pantalla */
        width: 300px; /* Tamaño ajustado */
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
        margin-bottom: 20px;
    }

    /* Estilo del botón de cerrar (X) */
    #modal-message .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 25px;
        font-weight: bold;
        color: #aaa;
        cursor: pointer;
    }

    #modal-message .close:hover {
        color: #333;
    }

    /* Estilo del botón dentro del modal */
    #modal-message button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    #modal-message button:hover {
        background-color: #0056b3;
    }
</style>


</body>
</html>
