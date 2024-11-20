<?php
require_once '../Controlador/RegistroProveedoresController.php';

$controller = new RegistroProveedoresController();
$proveedores = $controller->obtenerProveedores();

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
    <title>Registro de Proveedores</title>
    <link rel="stylesheet" href="../Style/Registro.css">
</head>

<body>
    <div class="container">
        <div class="h1container">
            <h1>Registro de Proveedores</h1>
        </div>
        <div class="main-content">
            <div class="form-container">
                <form id="registroForm" method="POST">
                    <input type="hidden" id="id_proveedor" name="id_proveedor">
                    <div class="form-group">
                        <label for="nombre_proveedor">Nombre Proveedor:</label>
                        <input type="text" id="nombre_proveedor" name="nombre_proveedor" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" required>
                    </div>
                    <div class="button-container">
                        <button type="submit" name="registrar" class="button">Registrar</button>
                        <button type="button" class="button" onclick="limpiarFormulario()">Limpiar</button>
                        <button type="submit" name="actualizar" class="button">Actualizar</button>
                        <button type="button" class="menu-button" onclick="MenuSegunUsuario()">Menú</button>
                    </div>
                </form>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID Usuario</th>
                            <th>ID Proveedor</th>
                            <th>Nombre Proveedor</th>
                            <th>Teléfono</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proveedores as $proveedor): ?>
                            <tr onclick="seleccionarProveedor(
                                '<?= htmlspecialchars($proveedor['idusuario']) ?>',
                                '<?= htmlspecialchars($proveedor['idproveedor']) ?>',
                                '<?= htmlspecialchars($proveedor['nombreproveedor']) ?>',
                                '<?= htmlspecialchars($proveedor['telefono']) ?>')">
                                <td><?= htmlspecialchars($proveedor['idusuario']) ?></td>
                                <td><?= htmlspecialchars($proveedor['idproveedor']) ?></td>
                                <td><?= htmlspecialchars($proveedor['nombreproveedor']) ?></td>
                                <td><?= htmlspecialchars($proveedor['telefono']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <script>
                function seleccionarProveedor(idUsuario, idProveedor, nombreProveedor, telefono) {
                    document.getElementById('id_proveedor').value = idProveedor;
                    document.getElementById('nombre_proveedor').value = nombreProveedor;
                    document.getElementById('telefono').value = telefono;
                }

                function limpiarFormulario() {
                    document.getElementById('registroForm').reset();
                }

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
                        window.location.href = '../login.php'; 
                    <?php endif; ?>
                }
            </script>
        </div>
    </div>
</body>

</html>
