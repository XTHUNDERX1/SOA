<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es un administrador
if (!isset($_SESSION['UsuarioID']) || $_SESSION['RolID'] != 1) {
    // Si no es administrador, redirigirlo a la página de login o a otro lugar
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> <!-- Enlace a Bootstrap -->
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
                <!-- Aquí se cargarán los usuarios desde la base de datos -->
                <?php
                include 'connect.php';
                $query = "SELECT Usuarios.UsuarioID, Usuarios.NombreUsuario, Usuarios.Email, Roles.NombreRol 
                          FROM Usuarios 
                          INNER JOIN Roles ON Usuarios.RolID = Roles.RolID";
                $result = $conn->query($query);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['UsuarioID'] . "</td>";
                    echo "<td>" . $row['NombreUsuario'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['NombreRol'] . "</td>";
                    echo "<td>
                            <a href='edit_user.php?id=" . $row['UsuarioID'] . "' class='btn btn-primary btn-sm'>Editar</a>
                            <a href='delete_user.php?id=" . $row['UsuarioID'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este usuario?\")'>Eliminar</a>
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
