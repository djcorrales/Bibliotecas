<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario - Biblioteca Virtual</title>
    <link rel="stylesheet" href="../public/css/Agregar_User.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<!-- Modal para agregar usuario -->
<div class="form-container">
    <h2>Agregar Nuevo Usuario</h2>

    <form action="../controller/User/AgregarUsuario.php" method="POST">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required>

        <label for="nombre_completo">Nombre Completo:</label>
        <input type="text" id="nombre_completo" name="nombre_completo" required>

        <label for="email">Correo:</label>
        <input type="email" id="email" name="email" required>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>

        <label for="role_id">Rol:</label>
        <select id="role_id" name="role_id" required>
            <option value="1">Administrador</option>
            <option value="2">Usuario</option>
        </select>

        <button type="submit">Agregar Usuario</button>
    </form>
</div>


<!-- Modal para mostrar mensajes -->
<div id="modal-message">
    <p id="message-content"></p>
    <button id="close-modal">Cerrar</button>
</div>

<script>
    $(document).ready(function () {
        // Manejo del envío del formulario
        $('form').on('submit', function (event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario
            var formData = $(this).serialize(); // Serializar los datos del formulario

            $.ajax({
                url: '../controller/User/AgregarUsuario.php',
                type: 'POST',
                data: formData,
                dataType: 'json', // Esperar una respuesta JSON del servidor
                success: function (response) {
                    $('#message-content').text(response.message); // Mostrar el mensaje del servidor
                    $('#modal-message').fadeIn(); // Mostrar el modal

                    if (response.status === "success") {
                        $('form')[0].reset(); // Limpiar el formulario en caso de éxito
                    }
                },
                error: function (xhr, status, error) {
                    $('#message-content').text("Hubo un error al procesar la solicitud.");
                    $('#modal-message').fadeIn();
                }
            });
        });

        // Cerrar modal
        $('#close-modal').click(function () {
            $('#modal-message').fadeOut();
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
