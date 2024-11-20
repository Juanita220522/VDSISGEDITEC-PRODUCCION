<?php
require_once '../Controlador/RegistroProductosController.php';
require_once '../Controlador/RegistroProveedoresController.php';

$controllerProductos = new RegistroProductosController();
$controllerProveedores = new RegistroProveedoresController();
$proveedores = $controllerProveedores->obtenerProveedores();

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
    <title>Registro de Productos</title>
    <link rel="stylesheet" href="../Style/Registro.css">
</head>

<body>
    <div class="container">
        <div class="h1container">
            <h1>Registro de Productos</h1>
        </div>
        <div class="main-content">
            <div class="form-container">
                <form id="registroForm" method="POST">
                    <div class="form-group">
                        <label for="id_proveedor">Proveedor:</label>
                        <select id="id_proveedor" name="id_proveedor" required>
                            <option value="">Seleccione un Proveedor</option>
                            <?php foreach ($proveedores as $proveedor): ?>
                                <option value="<?= htmlspecialchars($proveedor['idproveedor']) ?>">
                                    <?= htmlspecialchars($proveedor['nombreproveedor']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombre_producto">Nombre Producto:</label>
                        <input type="text" id="nombre_producto" name="nombre_producto" required>
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca:</label>
                        <input type="text" id="marca" name="marca" required>
                    </div>
                    <div class="form-group">
                        <label for="precio_unidad">Precio por Unidad:</label>
                        <input type="text" id="precio_unidad" name="precio_unidad" required>
                    </div>
                    <input type="hidden" id="id_producto" name="id_producto">
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
                            <th>Proveedor</th> 
                            <th>ID Producto</th>
                            <th>Nombre Producto</th>
                            <th>Marca</th>
                            <th>Precio por Unidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($controllerProductos->obtenerProductos() as $producto): ?>
                            <tr onclick="seleccionarProducto(
                                '<?= htmlspecialchars($producto['idusuario']) ?>',
                                '<?= htmlspecialchars($producto['idproducto']) ?>',
                                '<?= htmlspecialchars($producto['nombreproducto']) ?>',
                                '<?= htmlspecialchars($producto['marca']) ?>',
                                '<?= htmlspecialchars($producto['preciounidad']) ?>')">
                                <td><?= htmlspecialchars($producto['idusuario']) ?></td>
                                <td><?= htmlspecialchars($producto['nombreproveedor']) ?></td> 
                                <td><?= htmlspecialchars($producto['idproducto']) ?></td>
                                <td><?= htmlspecialchars($producto['nombreproducto']) ?></td>
                                <td><?= htmlspecialchars($producto['marca']) ?></td>
                                <td><?= htmlspecialchars($producto['preciounidad']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <script>
                function seleccionarProducto(idUsuario, idProducto, nombreProducto, marca, precioUnidad) {
                    document.getElementById('id_producto').value = idProducto;
                    document.getElementById('nombre_producto').value = nombreProducto;
                    document.getElementById('marca').value = marca;
                    document.getElementById('precio_unidad').value = precioUnidad;
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
