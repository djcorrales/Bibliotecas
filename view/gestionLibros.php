<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Libros - Biblioteca Virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../public/css/AgregarLibros.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
</head>
<body>

<div class="main">
    <h1>Gestión de Libros</h1>

    <!-- Contenedor de botones -->
    <div class="card-container">
        <div class="card">
            <h3>Agregar Libro</h3>
            <p>Haz clic aquí para agregar nuevos libros a la biblioteca.</p>
            <button onclick="loadContent('../view/agregarLibros.php', 'Agregar Libro')" class="button">Agregar Libro</button>
        </div>
        <div class="card">
            <h3>Ver Libros</h3>
            <p>Consulta todos los libros disponibles en la biblioteca.</p>
            <button onclick="loadContent('../view/verLibros.php', 'Ver Libros')" class="button">Ver Libros</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modal-title"></h2>
            <div id="modal-body">
                <!-- Aquí se cargará el contenido -->
            </div>
        </div>
    </div>
</div>

<script>
    // Cargar contenido en el modal
    function loadContent(url, title) {
        document.getElementById('modal-title').innerText = title;
        fetch(url)
            .then(response => response.text())
            .then(data => {
                document.getElementById('modal-body').innerHTML = data;
                document.getElementById('modal').style.display = 'flex';
            })
            .catch(error => console.error('Error al cargar el contenido:', error));
    }

    // Cerrar el modal
    function closeModal() {
        document.getElementById('modal').style.display = 'none';
    }

    // Enviar formulario con AJAX
    function enviarFormulario(event) {
        event.preventDefault(); // Evitar recarga de la página

        let form = new FormData(event.target);
        fetch(event.target.action, {
            method: 'POST',
            body: form
        })
        .then(response => response.text())
        .then(data => {
            // Mostrar el mensaje en el modal
            document.getElementById('modal-body').innerHTML = data;
        })
        .catch(error => console.error('Error al enviar formulario:', error));
    }
</script>

</body>
</html>
