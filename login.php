<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../Style/Login.css"> 
</head>
<body>
    <div class="login-container">
        <div class="header">
            <h2>Iniciar Sesión</h2>
            <p>Bienvenido, Ingresa para Continuar</p>
        </div>

        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error-message" style="color: red;">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        if (isset($_GET['success'])) {
            echo '<div class="success-message" style="color: green;">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        ?>

        <form action="../Controlador/LoginController.php" method="post">
            <label for="nombre_usuario">Usuario:</label>
            <input type="text" name="nombre_usuario" id="nombre_usuario" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit" name="login">Ingresar</button>
        </form>
    </div>
</body>
</html>
