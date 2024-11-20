<?php
require_once 'Conexion.php';

class Pedidos {
    public $conn;

    public $idusuario;
    public $idpedido;
    public $idproveedor;
    public $idproducto;
    public $idcliente;
    public $direccion;
    public $numeroitems;
    public $preciototal;
    public $telefono;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    

}
