<?php

class Connection {
    private $host = 'localhost';
    private $dbname = 'biblioteca'; // Asegúrate de que el nombre de la base de datos sea correcto
    private $username = 'root'; // Usuario de la base de datos
    private $password = ''; // Contraseña de la base de datos

    public function connect() {
        try {
            $conexion = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }
}
?>
