<?php
require_once '../Controlador/VisualizacionController.php';
$controller = new VisualizacionController();
$usuarios = $controller->obtenerUsuarios('usuarios');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados</title>
    <link rel="stylesheet" href="../Style/Visualizacion.css">
</head>

<body>

    <div class="h1container">
        <h1>Usuarios Registrados</h1>
    </div>
    <input type="text" id="searchInput" class="barrabusqueda" placeholder="Buscar usuario..." onkeyup="filtrarUsuarios()">

    <?php
    if (isset($_GET['mensaje'])) {
        echo '<div class="mensaje">' . htmlspecialchars($_GET['mensaje']) . '</div>';
    }
    ?>

    <div class="button-container">
        <table id="usuariosTable">
            <thead>
                <tr>
                    <th>ID Usuario</th>
                    <th>Nombre de Usuario</th>
                    <th>Password</th>
                    <th>Tipo de Usuario</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['idusuario']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombreusuario']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['password']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['tipousuario']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">No hay usuarios registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <button type="button" class="buttonpdf" onclick="exportarPDF()">Generar PDF</button>
    <button type="button" class="menu-button" onclick="MenuSegunUsuario()">Menu</button>

    <script>
        function filtrarUsuarios() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('usuariosTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let visible = false;
                const td = tr[i].getElementsByTagName('td');

                for (let j = 0; j < td.length; j++) {
                    if (td[j] && td[j].innerText.toLowerCase().indexOf(filter) > -1) {
                        visible = true;
                    }
                }

                tr[i].style.display = visible ? '' : 'none';
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
                window.location.href = '../login.php';
            <?php endif; ?>
        }

       
    async function exportarPDF() {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();

        const tabla = document.getElementById("usuariosTable");

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

            pdf.save("usuarios.pdf");
        });
    }


    </script>
</body>

</html>
