<?php
require_once '../config/conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $connection = new Connection(); 
        $pdo = $connection->connect();

        $sql = "SELECT * FROM usuarios WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role_id'] = $user['role_id'];

            // Redirección según el rol del usuario
            if ($user['role_id'] == 1) {
                header('Location: ../view/admin.php');
            } elseif ($user['role_id'] == 2) {
                header('Location: ../view/User.php');
            } else {
                echo 'Acceso denegado';
            }
            exit();
        } else {
            // Si las credenciales son incorrectas o el usuario no está registrado, establecer un mensaje en la sesión
            $_SESSION['error_message'] = 'Credenciales incorrectas o usuario no registrado. Intenta de nuevo.';
            header('Location: ../index.php'); // Redirigir al formulario de inicio de sesión
            exit();
        }
    } catch (Throwable $th) {
        // En caso de error en la conexión
        $_SESSION['error_message'] = 'Error en la conexión: ' . $th->getMessage();
        header('Location: ../index.php'); // Redirigir al formulario de inicio de sesión
        exit();
    }
}
