<?php 

require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nombre_completo = $_POST['nombre_completo'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role_id = $_POST['role_id'];

    // Validar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        echo "<script>
        alert('Las contraseñas no coinciden.');
        window.location.href = '../InicioSesion/registrarse.php'; // Redirige al formulario
        </script>";
        exit();
    }

    // Conexión a la base de datos
    try {
        $connection = new Connection();
        $pdo = $connection->connect();

        // Verificar si el nombre de usuario ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user_exists = $stmt->fetchColumn();

        // Verificar si el correo electrónico ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $email_exists = $stmt->fetchColumn();

        // Si el nombre de usuario o correo ya existe, mostrar un mensaje
        if ($user_exists > 0) {
            echo "<script>
            alert('El nombre de usuario ya está en uso.');
            window.location.href = '../registrarse.php'; // Redirige al formulario
            </script>";
            exit();
        }

        if ($email_exists > 0) {
            echo "<script>
            alert('El correo electrónico ya está en uso.');
            window.location.href = '../registrarse.php'; // Redirige al formulario
            </script>";
            exit();
        }

        // Encriptar la contraseña
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (username, email, password, nombre_completo, role_id, fecha_registro) 
                VALUES (:username, :email, :password, :nombre_completo, :role_id, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password,
            'nombre_completo' => $nombre_completo,
            'role_id' => $role_id
        ]);

        // Redirigir con un mensaje de éxito
        echo "<script>
        alert('Usuario registrado correctamente');
        window.location.href = '../index.php'; // Redirige al login 
        </script>";

    } catch (\Throwable $th) {
        // En caso de error
        echo "<script>
        alert('Error al registrar el usuario: " . addslashes($th->getMessage()) ."');
        window.location.href = '../registrarse.php'; // Redirige al registro 
        </script>";
    }
}
?>
