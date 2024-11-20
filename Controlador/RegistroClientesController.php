<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../Modelo/Clientes.php';

class RegistroClientesController {

    public function registrarCliente($nombreempresa, $nombrecliente, $linea, $direccion, $numerotelefono) {
        if (!isset($_SESSION['UsuarioActivo'])) {
            header("Location: /login.php"); 
            exit();
        }

        $idusuario = $_SESSION['UsuarioActivo']; 
        $cliente = new Clientes();

        $sql = "INSERT INTO cliente (idusuario, nombreempresa, nombrecliente, linea, direccion, numerotelefono) 
                VALUES (:idusuario, :nombreempresa, :nombrecliente, :linea, :direccion, :numerotelefono)";
        
        $stmt = $cliente->conn->prepare($sql);
        $stmt->bindParam(':idusuario', $idusuario);
        $stmt->bindParam(':nombreempresa', $nombreempresa);
        $stmt->bindParam(':nombrecliente', $nombrecliente);
        $stmt->bindParam(':linea', $linea);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':numerotelefono', $numerotelefono);

        if ($stmt->execute()) {
            header("Location: /Vista/registrarClientes.php?mensaje=Cliente registrado exitosamente");
            exit();
        } else {
            header("Location: /Vista/registrarClientes.php?mensaje=Error al registrar el cliente");
            exit();
        }
    }

    public function actualizarCliente($idcliente, $nombreempresa, $nombrecliente, $linea, $direccion, $numerotelefono) {
        $cliente = new Clientes();
        $sql = "UPDATE cliente SET nombreempresa = :nombreempresa, nombrecliente = :nombrecliente, 
                linea = :linea, direccion = :direccion, numerotelefono = :numerotelefono 
                WHERE idcliente = :idcliente";
        
        $stmt = $cliente->conn->prepare($sql);
        $stmt->bindParam(':idcliente', $idcliente);
        $stmt->bindParam(':nombreempresa', $nombreempresa);
        $stmt->bindParam(':nombrecliente', $nombrecliente);
        $stmt->bindParam(':linea', $linea);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':numerotelefono', $numerotelefono);

        if ($stmt->execute()) {
            header("Location: /Vista/registrarClientes.php?mensaje=Cliente actualizado exitosamente");
            exit();
        } else {
            header("Location: /Vista/registrarClientes.php?mensaje=Error al actualizar el cliente");
            exit();
        }
    }

    public function obtenerClientesSeleccionados() {
        $cliente = new Clientes();
        $sql = "SELECT * FROM cliente";
        $stmt = $cliente->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['registrar'])) {
    
        $nombreempresa = $_POST['nombre_empresa'];
        $nombrecliente = $_POST['nombre_cliente'];
        $linea = $_POST['linea'];
        $direccion = $_POST['direccion'];
        $numerotelefono = $_POST['numero_telefono'];
        $controller = new RegistroClientesController();
        $controller->registrarCliente($nombreempresa, $nombrecliente, $linea, $direccion, $numerotelefono);
    }
    
    if (isset($_POST['actualizar'])) {
      
        $idcliente = $_POST['id_cliente'];
        $nombreempresa = $_POST['nombre_empresa'];
        $nombrecliente = $_POST['nombre_cliente'];
        $linea = $_POST['linea'];
        $direccion = $_POST['direccion'];
        $numerotelefono = $_POST['numero_telefono'];
        $controller = new RegistroClientesController();
        $controller->actualizarCliente($idcliente, $nombreempresa, $nombrecliente, $linea, $direccion, $numerotelefono);
    }
}

