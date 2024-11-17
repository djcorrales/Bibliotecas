<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/BIBLIOTECAS/config/conexion.php';

// Crear conexión a la base de datos
$conexion = (new Connection())->connect();

// Consultar todos los usuarios (solo los roles 1 y 2)
$query = "SELECT id, username, nombre_completo, email, role_id FROM usuarios WHERE role_id IN (1, 2)";
$stmt = $conexion->prepare($query);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    /* Estilos básicos para la tabla y el modal */
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    td {
        background-color: #fff;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        color: white;
        background-color: #28a745;
        cursor: pointer;
        border-radius: 4px;
    }

    .btn-eliminar {
        background-color: #dc3545;
    }

    .btn:hover {
        opacity: 0.8;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        font-size: 18px;
        font-weight: bold;
        color: #007bff;
    }

    .modal-body {
        margin-bottom: 15px;
    }

    .modal-footer {
        display: flex;
        justify-content: space-between;
    }

    .input-field {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .btn-confirmar {
        background-color: #28a745;
    }

    .btn-cancelar {
        background-color: #6c757d;
    }

    .btn-cancelar:hover {
        background-color: #5a6268;
    }
    </style>
</head>

<body>

    <h2>Gestionar Usuarios</h2>

    <table>
        <thead>
            <tr>
                <th>Nombre de Usuario</th>
                <th>Nombre Completo</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr id="usuario-<?php echo $usuario['id']; ?>">
                <td><?php echo $usuario['username']; ?></td>
                <td><?php echo $usuario['nombre_completo']; ?></td>
                <td><?php echo $usuario['email']; ?></td>
                <td>
                    <!-- Botón para eliminar -->
                    <button class="btn btn-eliminar" data-id="<?php echo $usuario['id']; ?>">Eliminar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal para Confirmar eliminación -->
    <div id="modal-eliminar" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Eliminar Usuario</h4>
            </div>
            <div class="modal-body">
                <p>Ingresa la contraseña del administrador para confirmar la eliminación:</p>
                <input type="password" id="admin-password" class="input-field"
                    placeholder="Contraseña del administrador" required>
                <div id="mensaje"></div>
            </div>
            <div class="modal-footer">
                <button id="confirmar-eliminar" class="btn btn-confirmar">Confirmar</button>
                <button id="cancelar-eliminar" class="btn btn-cancelar">Cancelar</button>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        var usuarioId; // Almacenar el ID del usuario a eliminar

        // Abrir el modal para confirmar eliminación
        $('.btn-eliminar').click(function() {
            usuarioId = $(this).data('id'); // Obtener el ID del usuario
            $('#modal-eliminar').fadeIn(); // Mostrar el modal
        });

        // Cerrar el modal
        $('#cancelar-eliminar').click(function() {
            $('#modal-eliminar').fadeOut(); // Ocultar el modal
        });

        // Confirmar eliminación
        $('#confirmar-eliminar').click(function() {
            var password = $('#admin-password').val(); // Obtener la contraseña

            // Validar y eliminar usuario
            $.ajax({
                url: '../controller/user/eliminar_usuario.php', // URL del controlador PHP
                type: 'POST',
                data: {
                    eliminar: usuarioId,
                    password: password
                }, // Enviar los datos al backend
                success: function(response) {
                    var res = JSON.parse(response);

                    // Mostrar el mensaje de éxito o error
                    if (res.success) {
                        $('#usuario-' + usuarioId).remove(); // Eliminar la fila
                        $('#mensaje').html('<p style="color: green;">' + res.message +
                            '</p>');
                    } else {
                        $('#mensaje').html('<p style="color: red;">' + res.message +
                        '</p>');
                    }

                    // Cerrar el modal después de la eliminación
                    $('#modal-eliminar').fadeOut();
                },
                error: function() {
                    $('#mensaje').html(
                        '<p style="color: red;">Hubo un error al intentar eliminar el usuario.</p>'
                        );
                    // Cerrar el modal en caso de error
                    $('#modal-eliminar').fadeOut();
                }
            });
        });
    });
    </script>

</body>

</html>