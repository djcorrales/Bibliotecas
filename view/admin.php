
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/admin1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Biblioteca Virtual</title>
</head>
<body>
    <header><h2>Biblioteca virtual</h2></header>
    
    <nav>
        <a href="admin.php?page=inicioadmin"><i class="fas fa-home"></i> Inicio</a>
        <a href="admin.php?page=agregarLibros"><i class="fas fa-book"></i> Agregar Libros</a>
        <a href="admin.php?page=verLibros"><i class="fas fa-book"></i> Ver Libros</a>
        <a href="admin.php?page=agregar_User"><i class="fas fa-users"></i> Agregar Usuarios</a>
        <a href="admin.php?page=ver_User"><i class="fas fa-users"></i> Ver Usuarios</a>
        <a href="admin.php?page=prestamos"><i class="fas fa-exchange-alt"></i> Préstamos y Devoluciones</a>
        <a href="../login/CerrarSesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
    </nav>

    <main>
        <?php
        // Cargar la página según el parámetro 'page'
        $page = $_GET['page'] ?? 'inicio';
        switch ($page) {
            case 'agregarLibros':
                include '../view/agregarLibros.php';
                break;
            case 'verLibros':
                include '../view/verLibros.php';
                break;
            case 'agregar_User':
                include '../view/agregar_User.php';
                break;
            case 'ver_User':
                include '../view/ver_User.php';
                break;
            case 'prestamos':
                include '../view/prestamos_devoluciones.php';
                break;           
            default:
                include '../view/inicioadmin.php';
                break;
        }
        ?>
    </main>
</body>
</html>
