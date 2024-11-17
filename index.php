<?php
// Iniciar sesión
session_start();

// Verificar si hay un mensaje de error en la sesión (por ejemplo, desde InicioSesion.php)
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';

// Limpiar el mensaje de error después de mostrarlo
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Librería de íconos -->
    <title>Login por roles</title>
</head>

<body>
    <div class="wrapper">
        <div class="title">Inicia sesión</div>

        <!-- Mostrar el mensaje de error solo si hay un error -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de inicio de sesión -->
        <form action="login/InicioSesion.php" method="POST">
            <div class="field">
                <input type="text" required name="username">
                <label>Correo o usuario de red</label>
            </div>
            <div class="field">
                <input type="password" required name="password">
                <label>Contraseña</label>
            </div>
            <div class="content">
                <div class="checkbox">
                    <input type="checkbox" id="remember-me">
                    <label for="remember-me">Recordar</label>
                </div>
                <div class="pass-link"><a href="#">Olvidó su contraseña?</a></div>
            </div>
            <div class="field">
                <input type="submit" value="Ingresar">
            </div>
            <div class="signup-link"><a href="Registrarse.php">Registrarse Ahora</a></div>
        </form>
    </div>
    <style>
       body{
        background-image: url(./public/img/fondo2.jpg);
        background-repeat: no-repeat;
        background-size: cover; /* La imagen cubrirá toda la pantalla */
  background-position: center; /* Centrar la imagen */
  min-height: 100vh; /* Asegura que el fondo cubra al menos el 100% del alto de la ventana */
       }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
