<?php
require_once '../Controlador/RegistroPedidosController.php';
require_once '../Controlador/RegistroClientesController.php';

$controllerClientes = new RegistroClientesController();
$controllerPedidos = new RegistroPedidosController();

$clientes = $controllerClientes->obtenerClientesSeleccionados();
$productos = $controllerPedidos->obtenerProductos();
$pedidos = $controllerPedidos->obtenerPedidos();

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
    <title>Registro de Pedidos</title>
    <link rel="stylesheet" href="../Style/RegistroPedido.css">
</head>

<body>
    <div class="container">
        <div class="h1container">
            <h1>Registro de Pedidos</h1>
        </div>
        <div class="main-content">
            <div class="form-container">
                <form id="registroForm" method="POST" action="../Controlador/RegistroPedidosController.php">
                    <input type="hidden" id="idpedido" name="idpedido">

                    <div class="form-group">
                        <label for="idcliente">Cliente:</label>
                        <select id="idcliente" name="idcliente" onchange="actualizarDatosCliente()" required>
                            <option value="">Seleccione un Cliente</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= htmlspecialchars($cliente['idcliente']) ?>"
                                    data-direccion="<?= htmlspecialchars($cliente['direccion']) ?>"
                                    data-telefono="<?= htmlspecialchars($cliente['numerotelefono']) ?>">
                                    <?= htmlspecialchars($cliente['nombrecliente']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" readonly>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" readonly>
                    </div>

                    <div class="form-group">
                        <label for="idproducto">Producto:</label>
                        <select id="idproducto" name="idproducto" onchange="actualizarDatosProducto()" required>
                            <option value="">Seleccione un Producto</option>
                            <?php foreach ($productos as $producto): ?>
                                <option value="<?= htmlspecialchars($producto['idproducto']) ?>"
                                    data-preciounidad="<?= htmlspecialchars($producto['preciounidad']) ?>"
                                    data-idproveedor="<?= htmlspecialchars($producto['idproveedor']) ?>">
                                    <?= htmlspecialchars($producto['nombreproducto']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="preciounidad">Precio por Unidad:</label>
                        <input type="text" id="preciounidad" name="preciounidad" readonly>
                    </div>

                    <div class="form-group">
                        <label for="numeroitems">Número de Items:</label>
                        <input type="number" id="numeroitems" name="numeroitems" min="1" oninput="calcularPrecioTotal()" required>
                    </div>

                    <div class="form-group">
                        <label for="preciototal">Precio Total:</label>
                        <input type="text" id="preciototal" name="preciototal" readonly>
                    </div>

                    <input type="hidden" id="idproveedor" name="idproveedor">

                    <div class="button-container">
                        <button type="submit" name="registrar" class="button">Registrar Pedido</button>
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
                            <th>ID Pedido</th>
                            <th>ID Usuario</th>
                            <th>Cliente</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Producto</th>
                            <th>Proveedor</th>
                            <th>Número de Items</th>
                            <th>Precio Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr onclick="SeleccionarPedido(
                                '<?= htmlspecialchars($pedido['idpedido'] ?? '') ?>', 
                                '<?= htmlspecialchars($pedido['idcliente'] ?? '') ?>', 
                                '<?= htmlspecialchars($pedido['direccion'] ?? '') ?>', 
                                '<?= htmlspecialchars($pedido['telefono'] ?? '') ?>', 
                                '<?= htmlspecialchars($pedido['idproducto'] ?? '') ?>', 
                                '<?= htmlspecialchars($pedido['numeroitems'] ?? '') ?>', 
                                '<?= htmlspecialchars($pedido['preciototal'] ?? '') ?>')">
                                <td><?= htmlspecialchars($pedido['idpedido'] ?? '') ?></td>
                                <td><?= htmlspecialchars($pedido['idusuario'] ?? '') ?></td>
                                <td><?= htmlspecialchars($pedido['nombrecliente'] ?? '') ?></td>
                                <td><?= htmlspecialchars($pedido['direccion'] ?? '') ?></td>
                                <td><?= htmlspecialchars($pedido['telefono'] ?? '') ?></td>
                                <td><?= htmlspecialchars($pedido['nombreproducto'] ?? '') ?></td>
                                <td><?= htmlspecialchars($pedido['nombreproveedor'] ?? '') ?></td>
                                <td><?= htmlspecialchars($pedido['numeroitems'] ?? '') ?></td>
                                <td><?= htmlspecialchars($pedido['preciototal'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <script>
                function actualizarDatosCliente() {
                    const selectCliente = document.getElementById('idcliente');
                    const direccion = selectCliente.options[selectCliente.selectedIndex]?.getAttribute('data-direccion');
                    const telefono = selectCliente.options[selectCliente.selectedIndex]?.getAttribute('data-telefono');
                    document.getElementById('direccion').value = direccion || '';
                    document.getElementById('telefono').value = telefono || '';
                }

                function actualizarDatosProducto() {
                    const selectProducto = document.getElementById('idproducto');
                    const precioUnidad = selectProducto.options[selectProducto.selectedIndex]?.getAttribute('data-preciounidad');
                    const idProveedor = selectProducto.options[selectProducto.selectedIndex]?.getAttribute('data-idproveedor');
                    document.getElementById('preciounidad').value = precioUnidad || '';
                    document.getElementById('idproveedor').value = idProveedor || '';
                    calcularPrecioTotal();
                }

                function calcularPrecioTotal() {
                    const precioUnidad = parseFloat(document.getElementById('preciounidad').value) || 0;
                    const numeroItems = parseInt(document.getElementById('numeroitems').value) || 0;
                    document.getElementById('preciototal').value = (precioUnidad * numeroItems).toFixed(2);
                }

                function SeleccionarPedido(idpedido, idcliente, direccion, telefono, idproducto, numeroitems, preciototal) {
                    document.getElementById('idpedido').value = idpedido;
                    document.getElementById('idcliente').value = idcliente;
                    actualizarDatosCliente();

                    document.getElementById('direccion').value = direccion;
                    document.getElementById('telefono').value = telefono;

                    document.getElementById('idproducto').value = idproducto;
                    actualizarDatosProducto();

                    document.getElementById('numeroitems').value = numeroitems;
                    calcularPrecioTotal();
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
                        window.location.href = '../index.php';
                    <?php endif; ?>
                }
            </script>
        </div>
    </div>
</body>
</html>