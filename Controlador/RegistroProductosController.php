<?php
require_once '../Modelo/Productos.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

class RegistroProductosController {

    public function registrarProducto($idproveedor, $nombreproducto, $marca, $preciounidad) {
        if (!isset($_SESSION['UsuarioActivo'])) {
            header("Location: /index.php");
            exit();
        }

        $idusuario = $_SESSION['UsuarioActivo']; 
        $producto = new Producto();

        $sql = "INSERT INTO producto (idusuario, idproveedor, nombreproducto, marca, preciounidad) 
                VALUES (:idusuario, :idproveedor, :nombreproducto, :marca, :preciounidad)";
        
        $stmt = $producto->conn->prepare($sql);
        $stmt->bindParam(':idusuario', $idusuario);
        $stmt->bindParam(':idproveedor', $idproveedor);
        $stmt->bindParam(':nombreproducto', $nombreproducto);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':preciounidad', $preciounidad);

        if ($stmt->execute()) {
            header("Location: /Vista/registrarProductos.php?mensaje=Producto registrado exitosamente");
            exit();
        } else {
            header("Location: /Vista/registrarProductos.php?mensaje=Error al registrar el producto");
            exit();
        }
    }

    public function obtenerProveedores() {
        $proveedor = new Proveedores();
        $sql = "SELECT idproveedor, nombreproveedor FROM proveedor";
        $stmt = $proveedor->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarProducto($idproducto, $idproveedor, $nombreproducto, $marca, $preciounidad) {
        $producto = new Producto();
        $sql = "UPDATE producto SET idproveedor = :idproveedor, nombreproducto = :nombreproducto, 
                marca = :marca, preciounidad = :preciounidad WHERE idproducto = :idproducto";
        
        $stmt = $producto->conn->prepare($sql);
        $stmt->bindParam(':idproducto', $idproducto);
        $stmt->bindParam(':idproveedor', $idproveedor);
        $stmt->bindParam(':nombreproducto', $nombreproducto);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':preciounidad', $preciounidad);

        if ($stmt->execute()) {
            header("Location: /Vista/registrarProductos.php?mensaje=Producto actualizado exitosamente");
            exit();
        } else {
            header("Location: /Vista/registrarProductos.php?mensaje=Error al actualizar el producto");
            exit();
        }
    }

    public function obtenerProductos() {
        $producto = new Producto();
        $sql = "SELECT p.idusuario,p.idproducto, p.nombreproducto, p.marca, p.preciounidad, 
                       pr.nombreproveedor 
                FROM producto p 
                JOIN proveedor pr ON p.idproveedor = pr.idproveedor";
        $stmt = $producto->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RegistroProductosController();

    if (isset($_POST['registrar'])) {
        $idproveedor = $_POST['id_proveedor'];
        $nombreproducto = $_POST['nombre_producto'];
        $marca = $_POST['marca'];
        $preciounidad = $_POST['precio_unidad'];
        $controller->registrarProducto($idproveedor, $nombreproducto, $marca, $preciounidad);
    }

    if (isset($_POST['actualizar'])) {
        $idproducto = $_POST['id_producto'];
        $idproveedor = $_POST['id_proveedor'];
        $nombreproducto = $_POST['nombre_producto'];
        $marca = $_POST['marca'];
        $preciounidad = $_POST['precio_unidad'];
        $controller->actualizarProducto($idproducto, $idproveedor, $nombreproducto, $marca, $preciounidad);
    }
}
