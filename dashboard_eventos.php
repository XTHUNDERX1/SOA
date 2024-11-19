<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es un administrador
if (!isset($_SESSION['UsuarioID']) || $_SESSION['RolID'] != 2) {
    // Si no es administrador, redirigirlo a la página de login o a otro lugar
    header('Location: user_home.html');
    exit();
}

include 'connect.php'; // Incluir la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panel de Control - Eventos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> <!-- Enlace a Bootstrap -->
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Panel de Control de Eventos</h2>

        <!-- Botón para agregar un nuevo evento -->
        <div class="d-flex justify-content-end mb-3">
            <a href="registro_evento.html" class="btn btn-success">Agregar Nuevo Evento</a>
        </div>

        <!-- Tabla de eventos -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Tipo de Evento</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Cliente</th>
                    <th>Proveedor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener todos los eventos con los nombres de los clientes y proveedores
                $query = "SELECT 
                            eventos.EventoID, 
                            eventos.TipoEvento, 
                            eventos.Fecha, 
                            eventos.Lugar, 
                            clientes.NombreCliente AS Cliente, 
                            proveedores.NombreProveedor AS Proveedor 
                          FROM eventos
                          LEFT JOIN clientes ON eventos.ClienteID = clientes.ClienteID
                          LEFT JOIN proveedores ON eventos.ProveedorID = proveedores.ProveedorID";
                $result = $conn->query($query);

                // Mostrar los eventos en la tabla
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['EventoID'] . "</td>";
                    echo "<td>" . $row['TipoEvento'] . "</td>";
                    echo "<td>" . $row['Fecha'] . "</td>";
                    echo "<td>" . $row['Lugar'] . "</td>";
                    echo "<td>" . ($row['Cliente'] ? $row['Cliente'] : 'Sin Asignar') . "</td>";
                    echo "<td>" . ($row['Proveedor'] ? $row['Proveedor'] : 'Sin Asignar') . "</td>";
                    echo "<td>
                            <a href='edit_evento.php?id=" . $row['EventoID'] . "' class='btn btn-primary btn-sm'>Editar</a>
                            <a href='delete_evento.php?id=" . $row['EventoID'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este evento?\")'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>