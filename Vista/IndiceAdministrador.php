    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Indice Administrador</title>
        <link rel="stylesheet" href="../Style/Indices.css">
    </head>
    <a href="../ManualUsuario/ManualUsuario.pdf" target="_blank" class="buttonmanual">Manual de Usuario</a>

    <body>
        <div class="container">
            <div class="h1container">
                <h1>Administrador</h1>
            </div>


            <div class="button-container">
                <a href="visualizarUsuarios.php" class="button">Visualizar Usuarios</a>
                <a href="registrarUsuarios.php" class="button">Registrar Usuarios</a>

                <a href="visualizarProductos.php" class="button">Visualizar Productos</a>
                <a href="registrarProductos.php" class="button">Registrar Productos</a>

                <a href="visualizarClientes.php" class="button">Visualizar Clientes</a>
                <a href="registrarClientes.php" class="button">Registrar Clientes</a>

                <a href="visualizarProveedores.php" class="button">Visualizar Proveedores</a>
                <a href="registrarProveedores.php" class="button">Registrar Proveedores</a>
        
                <a href="visualizarPedidos.php" class="button">Visualizar Pedidos</a>
                <a href="registrarPedidos.php" class="button">Registrar Pedidos</a>
            </div>
        </div>
        <a href="/login.php" class="button">Volver al Login</a>

    
    <script>
    function abrirPDF() {
        window.open('../ManualUsuario/ManualUsuario.pdf', '_blank');
    }
    </script>
    </body>

    </html>