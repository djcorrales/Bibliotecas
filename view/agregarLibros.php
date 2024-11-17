<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Libro</title>
    <link rel="stylesheet" href="../public/css/AgregarLibros.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  
<!-- Modal de agregar libro -->
<div class="form-container">
    <h2>Agregar Nuevo Libro</h2>

    <!-- Formulario de agregar libro -->
    <form id="form-agregar-libro">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" required>

        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required>

        <label for="fecha_publicacion">Fecha de Publicación:</label>
        <input type="date" id="fecha_publicacion" name="fecha_publicacion" required>

        <label for="categoria">Categoría:</label>
        <input type="text" id="categoria" name="categoria" required>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required min="1">

        <button type="submit">Agregar Libro</button>
    </form>
</div>

<!-- Modal para mostrar mensajes -->
<div id="modal-message">
    <p id="message-content"></p>
    <button id="close-modal">Cerrar</button>
</div>

<script>
    $(document).ready(function () {
        // Manejar el envío del formulario con AJAX
        $('#form-agregar-libro').on('submit', function (event) {
            event.preventDefault(); // Prevenir el envío tradicional del formulario
            var formData = $(this).serialize(); // Serializar los datos del formulario

            $.ajax({
                url: '../controller/GestionLibros/agregarLibros.php', // Ruta del controlador
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#message-content').text(response.trim()); // Mostrar el mensaje
                    $('#modal-message').fadeIn(); // Mostrar el modal
                },
                error: function (xhr, status, error) {
                    $('#message-content').text("Hubo un error: " + error);
                    $('#modal-message').fadeIn();
                }
            });
        });

        // Cerrar el modal
        $('#close-modal').click(function () {
            $('#modal-message').fadeOut(); // Ocultar el modal
        });
    });
</script>

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
</body>
</html>
