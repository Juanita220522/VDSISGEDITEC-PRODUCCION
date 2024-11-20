<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  
}
require_once '../Modelo/Proveedores.php';

class RegistroProveedoresController {

    public function registrarProveedor($nombreProveedor, $telefono) {
        if (!isset($_SESSION['UsuarioActivo'])) {
            header("Location: /login.php"); 
            exit();
        }

        $idusuario = $_SESSION['UsuarioActivo']; 
        $proveedor = new Proveedores();

        $sql = "INSERT INTO proveedor (idusuario, nombreproveedor, telefono) 
                VALUES (:idusuario, :nombreproveedor, :telefono)";
        
        $stmt = $proveedor->conn->prepare($sql);
        $stmt->bindParam(':idusuario', $idusuario);
        $stmt->bindParam(':nombreproveedor', $nombreProveedor);
        $stmt->bindParam(':telefono', $telefono);

        if ($stmt->execute()) {
            header("Location: /Vista/registrarProveedores.php?mensaje=Proveedor registrado exitosamente");
            exit();
        } else {
            header("Location: /Vista/registrarProveedores.php?mensaje=Error al registrar el proveedor");
            exit();
        }
    }

    public function actualizarProveedor($idproveedor, $nombreProveedor, $telefono) {
        $proveedor = new Proveedores();
        $sql = "UPDATE proveedor SET nombreproveedor = :nombreproveedor, telefono = :telefono 
                WHERE idproveedor = :idproveedor";
        
        $stmt = $proveedor->conn->prepare($sql);
        $stmt->bindParam(':idproveedor', $idproveedor);
        $stmt->bindParam(':nombreproveedor', $nombreProveedor);
        $stmt->bindParam(':telefono', $telefono);

        if ($stmt->execute()) {
            header("Location: /Vista/registrarProveedores.php?mensaje=Proveedor actualizado exitosamente");
            exit();
        } else {
            header("Location: /Vista/registrarProveedores.php?mensaje=Error al actualizar el proveedor");
            exit();
        }
    }

    public function obtenerProveedores() {
        $proveedor = new Proveedores();
        $sql = "SELECT * FROM proveedor";
        $stmt = $proveedor->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RegistroProveedoresController();

    if (isset($_POST['registrar'])) {
        $nombreProveedor = $_POST['nombre_proveedor'];
        $telefono = $_POST['telefono'];
        $controller->registrarProveedor($nombreProveedor, $telefono);
    }

    if (isset($_POST['actualizar'])) {
        $idproveedor = $_POST['id_proveedor'];
        $nombreProveedor = $_POST['nombre_proveedor'];
        $telefono = $_POST['telefono'];
        $controller->actualizarProveedor($idproveedor, $nombreProveedor, $telefono);
    }
}
