<?php
require_once 'Conexion.php';

class Producto {
    public $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }
}
