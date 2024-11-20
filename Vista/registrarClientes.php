<?php
require_once '../Controlador/RegistroClientesController.php';

$controller = new RegistroClientesController();
$clientes = $controller->obtenerClientesSeleccionados();

if (isset($_GET['mensaje'])): ?>
    <script>
        alert("<?= htmlspecialchars($_GET['mensaje']) ?>");
        document.getElementById('registroForm').reset();
    </script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Clientes</title>
    <link rel="stylesheet" href="../Style/Registro.css">
</head>

<body>
    <div class="container">
        <div class="h1container">
            <h1>Registro de Clientes</h1>
        </div>
        <div class="main-content">
            <div class="form-container">
                <form id="registroForm" method="POST">
                    <input type="hidden" id="id_cliente" name="id_cliente">
                    <div class="form-group">
                        <label for="nombre_empresa">Nombre Empresa:</label>
                        <input type="text" id="nombre_empresa" name="nombre_empresa" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre_cliente">Nombre Cliente:</label>
                        <input type="text" id="nombre_cliente" name="nombre_cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="linea">Linea:</label>
                        <input type="text" id="linea" name="linea" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Direccion:</label>
                        <input type="text" id="direccion" name="direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="numero_telefono">Numero Telefonico:</label>
                        <input type="text" id="numero_telefono" name="numero_telefono" required>
                    </div>
                    <div class="button-container">
                        <button type="submit" name="registrar" class="button">Registrar</button>
                        <button type="button" class="button" onclick="limpiarFormulario()">Limpiar</button>
                        <button type="submit" name="actualizar" class="button">Actualizar</button>
                        <button type="button" class="menu-button" onclick="MenuSegunUsuario()"='menu.php'">Menu</button>
                    </div>
                </form>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID Usuario</th>
                            <th>ID Cliente</th>
                            <th>Nombre Empresa</th>
                            <th>Nombre Cliente</th>
                            <th>Linea</th>
                            <th>Direccion</th>
                            <th>Numero Telefonico</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr onclick="seleccionarCliente(
                                '<?= htmlspecialchars($cliente['idusuario']) ?>',
                                '<?= htmlspecialchars($cliente['idcliente']) ?>',
                                '<?= htmlspecialchars($cliente['nombreempresa']) ?>',
                                '<?= htmlspecialchars($cliente['nombrecliente']) ?>',
                                '<?= htmlspecialchars($cliente['linea']) ?>',
                                '<?= htmlspecialchars($cliente['direccion']) ?>',
                                '<?= htmlspecialchars($cliente['numerotelefono']) ?>')">
                                <td><?= htmlspecialchars($cliente['idusuario']) ?></td>
                                <td><?= htmlspecialchars($cliente['idcliente']) ?></td>
                                <td><?= htmlspecialchars($cliente['nombreempresa']) ?></td>
                                <td><?= htmlspecialchars($cliente['nombrecliente']) ?></td>
                                <td><?= htmlspecialchars($cliente['linea']) ?></td>
                                <td><?= htmlspecialchars($cliente['direccion']) ?></td>
                                <td><?= htmlspecialchars($cliente['numerotelefono']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <script>
                function seleccionarCliente(idUsuario, idCliente, nombreEmpresa, nombreCliente, linea, direccion, numeroTelefono) {
                    document.getElementById('id_cliente').value = idCliente;
                    document.getElementById('nombre_empresa').value = nombreEmpresa;
                    document.getElementById('nombre_cliente').value = nombreCliente;
                    document.getElementById('linea').value = linea;
                    document.getElementById('direccion').value = direccion;
                    document.getElementById('numero_telefono').value = numeroTelefono;
                }

                function limpiarFormulario() {
                    document.getElementById('registroForm').reset();
                }
            </script>

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

        </div>
    </div>
</body>

</html>