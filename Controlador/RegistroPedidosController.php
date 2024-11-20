<?php
require_once '../Modelo/Conexion.php';
require_once '../Modelo/Productos.php';
require_once '../Modelo/Clientes.php';
require_once '../Modelo/Proveedores.php';
require_once '../Modelo/Pedidos.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class RegistroPedidosController
{
    public function registrarPedido($idproveedor, $idproducto, $idcliente, $direccion, $numeroitems, $preciototal, $telefono)
    {
        if (!isset($_SESSION['UsuarioActivo'])) {
            header("Location: /login.php");
            exit();
        }

        $idusuario = $_SESSION['UsuarioActivo'];
        $conexion = new Conexion();
        $conn = $conexion->conectar();

        $sql = "INSERT INTO pedido (idusuario, idproveedor, idproducto, idcliente, direccion, numeroitems, preciototal, telefono) 
                VALUES (:idusuario, :idproveedor, :idproducto, :idcliente, :direccion, :numeroitems, :preciototal, :telefono)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idusuario', $idusuario);
        $stmt->bindParam(':idproveedor', $idproveedor);
        $stmt->bindParam(':idproducto', $idproducto);
        $stmt->bindParam(':idcliente', $idcliente);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':numeroitems', $numeroitems);
        $stmt->bindParam(':preciototal', $preciototal);
        $stmt->bindParam(':telefono', $telefono);

        if ($stmt->execute()) {
            header("Location: ../Vista/registrarPedidos.php?mensaje=Pedido registrado exitosamente");
            exit();
        } else {
            header("Location: ../Vista/registrarPedidos.php?mensaje=Error al registrar el pedido");
            exit();
        }
    }

    public function actualizarPedido($idpedido, $idcliente, $idproducto, $numeroitems, $preciototal, $idproveedor, $direccion, $telefono)
    {
        if (!isset($_SESSION['UsuarioActivo'])) {
            header("Location: /login.php");
            exit();
        }

        $conexion = new Conexion();
        $conn = $conexion->conectar();

        $sql = "UPDATE pedido SET 
                idcliente = :idcliente, 
                idproducto = :idproducto, 
                numeroitems = :numeroitems, 
                preciototal = :preciototal, 
                idproveedor = :idproveedor, 
                direccion = :direccion, 
                telefono = :telefono
            WHERE idpedido = :idpedido";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idpedido', $idpedido, PDO::PARAM_INT);
        $stmt->bindParam(':idcliente', $idcliente, PDO::PARAM_INT);
        $stmt->bindParam(':idproducto', $idproducto, PDO::PARAM_INT);
        $stmt->bindParam(':numeroitems', $numeroitems, PDO::PARAM_INT);
        $stmt->bindParam(':preciototal', $preciototal, PDO::PARAM_STR);
        $stmt->bindParam(':idproveedor', $idproveedor, PDO::PARAM_INT);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                header("Location: ../Vista/registrarPedidos.php?mensaje=Pedido actualizado exitosamente");
            } else {
                echo "No hubo cambios en el pedido.";
            }
        } else {
            echo "Error al ejecutar la actualización.";
        }

        exit();
    }

    public function obtenerClientes()
    {
        $conexion = new Conexion();
        $conn = $conexion->conectar();

        $sql = "SELECT idcliente, nombrecliente, direccion, numerotelefono FROM cliente";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductos()
    {
        $conexion = new Conexion();
        $conn = $conexion->conectar();

        $sql = "SELECT idproducto, nombreproducto, preciounidad, idproveedor FROM producto";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProveedores()
    {
        $conexion = new Conexion();
        $conn = $conexion->conectar();

        $sql = "SELECT idproveedor, nombreproveedor FROM proveedor";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPedidos()
    {
        $conexion = new Conexion();
        $conn = $conexion->conectar();

        $sql = "SELECT 
                    p.idpedido,
                    p.idusuario,
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

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function calcularPrecioTotal($precioUnidad, $numeroItems)
    {
        return $precioUnidad * $numeroItems;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RegistroPedidosController();

    if (isset($_POST['registrar'])) {
        $controller->registrarPedido($_POST['idproveedor'], $_POST['idproducto'], $_POST['idcliente'], $_POST['direccion'], $_POST['numeroitems'], $_POST['preciototal'], $_POST['telefono']);
    }

    if (isset($_POST['actualizar'])) {
        $controller->actualizarPedido($_POST['idpedido'], $_POST['idcliente'], $_POST['idproducto'], $_POST['numeroitems'], $_POST['preciototal'], $_POST['idproveedor'], $_POST['direccion'], $_POST['telefono']);
    }
}

if (isset($_GET['obtenerPedido'])) {
    $controller = new RegistroPedidosController();
    $pedido = $controller->obtenerPedidos();
    echo json_encode($pedido);
    exit();
}
?>
