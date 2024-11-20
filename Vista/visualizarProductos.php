<?php
require_once '../Controlador/VisualizacionController.php';
$controller = new VisualizacionController();
$productos = $controller->obtenerProductos();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Registrados</title>
    <link rel="stylesheet" href="../Style/Visualizacion.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>

<body>
    <div class="h1container">
        <h1>Productos Registrados</h1>
    </div>

    <input type="text" id="searchInput" class="barrabusqueda" placeholder="Buscar producto..." onkeyup="filtrarProductos()">

    <?php
    if (isset($_GET['mensaje'])) {
        echo '<div class="mensaje">' . htmlspecialchars($_GET['mensaje']) . '</div>';
    }
    ?>

    <div class="button-container">
        <table id="productosTable">
            <thead>
                <tr>
                    <th>ID Producto</th>
                    <th>Nombre del Producto</th>
                    <th>Marca</th>
                    <th>Precio por Unidad</th>
                    <th>Proveedor</th>
                </tr>
            </thead>
            <tbody id="productoTableBody">
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['idproducto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombreproducto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['marca']); ?></td>
                            <td><?php echo htmlspecialchars($producto['preciounidad']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombreproveedor']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">No hay productos registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <button type="button" class="buttonpdf" onclick="exportarPDF()">Generar PDF</button>
    <button type="button" class="menu-button" onclick="MenuSegunUsuario()">Menu</button>

    <script>
        function filtrarProductos() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('productoTableBody');
            const rows = table.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }

                if (found) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
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

        async function exportarPDF() {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF();

            const tabla = document.getElementById("productosTable");

            const options = {
                scale: 4,
                useCORS: true
            };

            html2canvas(tabla, options).then((canvas) => {
                const imgData = canvas.toDataURL("image/png");
                const imgWidth = 190; 
                const pageHeight = 295; 
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                let position = 10;

                pdf.addImage(imgData, "PNG", 10, position, imgWidth, imgHeight);
                pdf.save("productos.pdf");
            });
        }
    </script>
</body>

</html>
