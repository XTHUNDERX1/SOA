<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es un administrador
if (!isset($_SESSION['UsuarioID']) || $_SESSION['RolID'] != 3) {
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
    <title>Panel de Control - Proveedores</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> <!-- Enlace a Bootstrap -->
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Panel de Control de Proveedores</h2>

        <!-- Botón para agregar un nuevo proveedor -->
        <div class="d-flex justify-content-end mb-3">
            <a href="registro_proveedor.html" class="btn btn-success">Agregar Nuevo Proveedor</a>
        </div>

        <!-- Tabla de proveedores -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre del Proveedor</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Reputación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener todos los proveedores
                $query = "SELECT * FROM proveedores";
                $result = $conn->query($query);

                // Mostrar los proveedores en la tabla
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['ProveedorID'] . "</td>";
                    echo "<td>" . $row['NombreProveedor'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Telefono'] . "</td>";
                    echo "<td>" . $row['Direccion'] . "</td>";
                    echo "<td>" . $row['Reputacion'] . "</td>";
                    echo "<td>
                            <a href='update_proveedor.php?id=" . $row['ProveedorID'] . "' class='btn btn-primary btn-sm'>Editar</a>
                            <a href='eliminar_proveedores.php?id=" . $row['ProveedorID'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este proveedor?\")'>Eliminar</a>
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