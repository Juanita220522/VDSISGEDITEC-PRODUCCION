<?php
require_once '../Modelo/Conexion.php';
require_once '../Modelo/Productos.php';
require_once '../Modelo/Clientes.php';
require_once '../Modelo/Proveedores.php';
require_once '../Modelo/Pedidos.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class VisualizacionController
{

    private $conn;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    public function obtenerUsuarios()
    {
        $sql = "SELECT idusuario, nombreusuario, password, tipousuario FROM usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductos()
    {
        $producto = new Producto();
        $sql = "SELECT p.idusuario, p.idproducto, p.nombreproducto, p.marca, p.preciounidad, 
                       pr.nombreproveedor 
                FROM producto p 
                JOIN proveedor pr ON p.idproveedor = pr.idproveedor";
        $stmt = $producto->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerClientes()
    {
        $cliente = new Clientes();
        $sql = "SELECT idcliente, nombreempresa, nombrecliente, linea, direccion, numerotelefono FROM cliente";
        $stmt = $cliente->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerProveedores()
    {
        $proveedor = new Proveedores();
        $sql = "SELECT idproveedor, nombreproveedor, telefono FROM proveedor";
        $stmt = $proveedor->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPedidos()
    {
        $pedido = new Pedidos();
        $sql = "SELECT 
                    p.idusuario,
                    p.idpedido,
                    p.idcliente,
                    p.idproducto,
                    p.idproveedor,
                    pr.nombreproveedor AS nombreproveedor,
                    prod.nombreproducto AS nombreproducto,
                    cl.nombrecliente AS nombrecliente,
                    p.direccion,
                    p.numeroitems,
                    p.preciototal,
                    p.telefono
                FROM pedido p
                JOIN proveedor pr ON p.idproveedor = pr.idproveedor
                JOIN producto prod ON p.idproducto = prod.idproducto
                JOIN cliente cl ON p.idcliente = cl.idcliente";

        $stmt = $pedido->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerRegistros($tabla)
    {
        $sql = "SELECT * FROM " . $tabla;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (isset($_GET['tabla'])) {
    $controller = new VisualizacionController();
    $tabla = $_GET['tabla'];

    if ($tabla === 'usuarios') {
        $usuarios = $controller->obtenerUsuarios();
        echo json_encode($usuarios);
    } else {
        $registros = $controller->obtenerRegistros($tabla);
        echo json_encode($registros);
    }
    exit();
}
