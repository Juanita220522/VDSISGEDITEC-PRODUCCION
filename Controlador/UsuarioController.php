<?php
require_once '../Modelo/Usuario.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();  
}
class UsuarioController {
    public function registrarUsuario($nombreusuario, $password, $tipousuario) {
        $usuario = new Usuario();

        if ($usuario->usuarioExiste($nombreusuario)) {
            return "El nombre de usuario ya está en uso.";
        }

        if ($usuario->registrar($nombreusuario, $password, $tipousuario)) {
            return "Usuario registrado exitosamente.";
        } else {
            return "Error al registrar el usuario.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreusuario = $_POST['nombreusuario'];
    $password = $_POST['password'];
    $tipousuario = $_POST['tipousuario'];

    $controller = new UsuarioController();
    $resultado = $controller->registrarUsuario($nombreusuario, $password, $tipousuario);

    header("Location: ../Vista/registrarUsuarios.php?mensaje=" . urlencode($resultado));
    exit();
}
?>
