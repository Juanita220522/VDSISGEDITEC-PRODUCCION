<?php
require_once 'Conexion.php';

class Usuario {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    public function login($nombreusuario, $password) {
        $query = "SELECT * FROM usuario WHERE nombreusuario = :nombreusuario AND password = :password";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nombreusuario', $nombreusuario);
        $stmt->bindParam(':password', $password);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function obtenerTipoUsuario($nombreusuario) {
        $query = "SELECT tipousuario FROM usuario WHERE nombreusuario = :nombreusuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombreusuario', $nombreusuario);
        
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['tipousuario'] ?? null;
    }

    public function usuarioExiste($nombreusuario) {
        $query = "SELECT COUNT(*) FROM usuario WHERE nombreusuario = :nombreusuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombreusuario', $nombreusuario);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function registrar($nombreusuario, $password, $tipousuario) {
        $query = "INSERT INTO usuario (nombreusuario, password, tipousuario) VALUES (:nombreusuario, :password, :tipousuario)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nombreusuario', $nombreusuario);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':tipousuario', $tipousuario);

        return $stmt->execute();
    }
}
?>
