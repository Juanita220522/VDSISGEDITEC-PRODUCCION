<?php
class Conexion {
    private $host = 'sql209.infinityfree.com';
    private $db_name = 'if0_37745487_vdesisgeditecphp';
    private $username = 'if0_37745487';
    private $password = 'G0dEfe6Vn38qbvu';
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
