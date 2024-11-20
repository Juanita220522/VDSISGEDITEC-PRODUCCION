<?php
require_once '../Controlador/VisualizacionController.php';

$controller = new VisualizacionController();
$clientes = $controller->obtenerClientes();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Registrados</title>
    <link rel="stylesheet" href="../Style/Visualizacion.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>

<body>

    <div class="h1container">
        <h1>Clientes Registrados</h1>
    </div>

    <input type="text" id="searchInput" class="barrabusqueda" placeholder="Buscar cliente..." onkeyup="filtrarClientes()">

    <?php
    if (isset($_GET['mensaje'])) {
        echo '<div class="mensaje">' . htmlspecialchars($_GET['mensaje']) . '</div>';
    }
    ?>

    <div class="button-container">
        <table id="clientesTable">
            <thead>
                <tr>
                    <th>ID Cliente</th>
                    <th>Nombre de Empresa</th>
                    <th>Nombre de Cliente</th>
                    <th>Línea</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody id="clienteTableBody">
                <?php if (!empty($clientes)): ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cliente['idcliente']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['nombreempresa']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['nombrecliente']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['linea']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['direccion']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['numerotelefono']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No hay clientes registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <button type="button" class="buttonpdf" onclick="exportarPDF()">Generar PDF</button>
    <button type="button" class="menu-button" onclick="MenuSegunUsuario()">Menu</button>

    <script>
        function filtrarClientes() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('clienteTableBody');
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

            const tabla = document.getElementById("clientesTable");

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
                pdf.save("clientes.pdf");
            });
        }
    </script>

</body>

</html>
