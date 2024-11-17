<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca-Virtual</title>
    <link rel="stylesheet" href="../public/css/inicioadmin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Librería de íconos -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
</head>
<body>
    <div class="main">
        <div class="title">
        <h1>Bienvenido al Dashboard</h1>
        </div>
        

        <!-- Tarjeta con el número de usuarios registrados hoy -->
        <div class="card">
           
            <h3>Usuarios Registrados Hoy</h3>
            <p>
                <strong>Número de usuarios registrados hoy:</strong>
                <?php
                // Conexión a la base de datos
                require_once '../config/conexion.php';

                try {
                    // Instanciamos la conexión
                    $connection = new Connection();
                    $pdo = $connection->connect();

                    // Consultamos el número de usuarios registrados hoy
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE DATE(fecha_registro) = CURDATE()");
                    $stmt->execute();
                    $usuarios_registrados_hoy = $stmt->fetchColumn();

                    // Mostramos el resultado
                    echo $usuarios_registrados_hoy;
                } catch (\Throwable $th) {
                    // En caso de error en la consulta
                    echo "Error al obtener los usuarios registrados hoy: " . $th->getMessage();
                }
                ?>
            </p>
        </div>

        <div class="card">
            <h3>Resumen de Actividades</h3>
            <p>Aquí puedes ver un resumen de tus actividades recientes.</p>
        </div>

        <div class="card">
            <h3>Estadísticas Recientes</h3>
            <p>Visualiza las estadísticas más recientes aquí.</p>
        </div>
    </div>
</body>
</html>
