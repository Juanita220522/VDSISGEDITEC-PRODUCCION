<?php
class Conexion {
    private $host = 'localhost';
    private $db_name = 'vdesisgeditecphp';
    private $username = 'root';
    private $password = '12345678';
    private $conn;

    public function conectar() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>