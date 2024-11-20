<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="../Style/registroUsuario.css">
</head>

<body>
    <div class="container">
        <h1>Registrar Usuario</h1>
        <form action="../Controlador/UsuarioController.php" method="post" id="registroForm">
            <label for="nombreusuario">Usuario:</label>
            <input type="text" name="nombreusuario" id="nombreusuario" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
            
            <label for="tipousuario">Tipo de Usuario:</label>
            <select name="tipousuario" id="tipousuario" required>
                <option value="Administrador">Administrador</option>
                <option value="Proveedor">Proveedor</option>
                <option value="Cliente">Cliente</option>
            </select>
            
            <button type="submit">REGISTRAR</button>
        </form>
        <button type="button" class="menu-button" onclick="MenuSegunUsuario()"='menu.php'">Menu</button>
    </div>

    <script>
                function MenuSegunUsuario() {
                    <?php if (isset($_SESSION['tipo_usuario'])): ?>
                        var tipoUsuario = "<?= $_SESSION['tipo_usuario'] ?>";
                        switch (tipoUsuario) {
                            case 'Administrador':
                                window.location.href = '../Vista/IndiceAdministrador.php';
                                break;
                            case 'Cliente':
                                window.location.href = '../Vista/IndiceCliente.php';
                                break;
                            case 'Proveedor':
                                window.location.href = '../Vista/IndiceProveedor.php';
                                break;
                            default:
                                alert("Tipo de usuario no reconocido");
                                break;
                        }
                    <?php else: ?>
                        alert("No se ha iniciado sesión");
                        window.location.href = '../index.php'; 
                    <?php endif; ?>
                }
            </script>

    
    <?php if (isset($_GET['mensaje'])): ?>
        <script>
            alert("<?= htmlspecialchars($_GET['mensaje']) ?>");
            document.getElementById('registroForm').reset();
        </script>
    <?php endif; ?>
</body>
</html>
