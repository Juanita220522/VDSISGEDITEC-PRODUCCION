<?php
require_once '../Modelo/Usuario.php';

class LoginController
{
    public function login($nombre_usuario, $password)
    {
        $usuario = new Usuario();
        $datosUsuario = $usuario->login($nombre_usuario, $password);

        if ($datosUsuario) {
            session_start();
            $_SESSION['UsuarioActivo'] = $datosUsuario['idusuario'];
            $_SESSION['usuario'] = $datosUsuario['nombreusuario'];
            $_SESSION['tipo_usuario'] = $datosUsuario['tipousuario'];

            switch ($datosUsuario['tipousuario']) {
                case 'Administrador':
                    header("Location: ../Vista/IndiceAdministrador.php");
                    exit();
                case 'Cliente':
                    header("Location: ../Vista/IndiceCliente.php");
                    exit();
                case 'Proveedor':
                    header("Location: ../Vista/IndiceProveedor.php");
                    exit();
                default:
                    echo "Tipo de usuario no reconocido.";
                    break;
            }
        } else {
            header("Location: ../index.php?error=Usuario o contraseña incorrectos.");
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password'];

    $loginController = new LoginController();
    $loginController->login($nombre_usuario, $password);
}
