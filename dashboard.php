<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es un administrador
if (!isset($_SESSION['UsuarioID']) || $_SESSION['RolID'] != 1) {
    header('Location: user_home.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panel de Control - Usuarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Panel de Control de Usuarios</h2>

        <!-- Botón para agregar un nuevo usuario -->
        <div class="d-flex justify-content-end mb-3">
            <a href="registro.html" class="btn btn-success">Agregar Nuevo Usuario</a>
        </div>

        <!-- Tabla de usuarios -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'connect.php';

                // Verificar conexión
                if (!$conn) {
                    echo "<tr><td colspan='5' class='text-center text-danger'>Error de conexión: " . mysqli_connect_error() . "</td></tr>";
                    exit();
                }

                // Consulta SQL
                $query = "SELECT Usuarios.UsuarioID, Usuarios.NombreUsuario, Usuarios.Email, Roles.NombreRol 
                          FROM Usuarios 
                          LEFT JOIN Roles ON Usuarios.RolID = Roles.RolID";

                $result = $conn->query($query);

                if (!$result) {
                    // Depuración si la consulta falla
                    echo "<tr><td colspan='5' class='text-center text-danger'>Error en la consulta SQL: " . $conn->error . "</td></tr>";
                } elseif ($result->num_rows == 0) {
                    // Mensaje si no hay resultados
                    echo "<tr><td colspan='5' class='text-center'>No se encontraron usuarios en la base de datos.</td></tr>";
                } else {
                    // Mostrar resultados
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['UsuarioID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['NombreUsuario']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['NombreRol'] ? $row['NombreRol'] : 'Sin rol') . "</td>";
                        echo "<td>
                                <a href='edit_user.php?id=" . htmlspecialchars($row['UsuarioID']) . "' class='btn btn-primary btn-sm'>Editar</a>
                                <a href='delete_user.php?id=" . htmlspecialchars($row['UsuarioID']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este usuario?\")'>Eliminar</a>
                              </td>";
                        echo "</tr>";
                    }
                }

                // Liberar resultados
                if ($result) {
                    $result->free();
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
