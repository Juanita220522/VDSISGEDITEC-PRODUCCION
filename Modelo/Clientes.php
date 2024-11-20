<?php
require_once 'Conexion.php'; 

class Clientes {
    public $conn;

    public $idusuario;
    public $idcliente;
    public $nombreempresa;
    public $nombrecliente;
    public $linea;
    public $direccion;
    public $numerotelefono;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }


    
}
?>
