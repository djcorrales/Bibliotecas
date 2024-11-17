<?php
session_start(); // Aquí se inicia la sesión
if (isset($_SESSION['username'])) {
    echo   '<h2>' . 'Bienvenido ' . htmlspecialchars($_SESSION['username']) . '</h2>';
} else {
    echo '<h2>No hay sesión activa.</h2>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/user.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>MI BIBLIOTECA VIRTUAL</title>
</head>
<body>

<nav>
    <h2><?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <a href="User.php?page=inicio"><i class="fas fa-home"></i> Inicio</a>
    <a href="User.php?page=misprestamos"><i class="fas fa-users"></i> Mis prestamos</a>
    <a href="../login/CerrarSesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
</nav>

<main>
<?php
$page = $_GET['page'] ?? 'inicio';
$termino = $_GET['termino'] ?? '';

switch ($page) {
    case 'misprestamos':
        include '../view/misPrestamos.php';
        break;
    default:
        include '../view/dash_Usuario.php';
        break;
}
?>


</main>
</body>
</html>
