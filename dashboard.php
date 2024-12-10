<?php
// Configuración de conexión
$servername = "127.0.0.1";
$username = "u855900840_william";
$password = "SOA@utp123";
$dbname = "u855900840_eventos_peru";

// Crear conexión con mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta de usuarios
$query = "SELECT UsuarioID, NombreUsuario, Email, NombreRol 
          FROM Usuarios 
          INNER JOIN roles ON Usuarios.RolID = roles.RolID";

$result = $conn->query($query);

if (!$result) {
    echo "<div class='alert alert-danger' role='alert'>Error en la consulta: " . $conn->error . "</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Lista de Usuarios</h2>
    <div class="d-flex justify-content-between mb-3">
        <a href="registro.html" class="btn btn-success">Agregar Nuevo Usuario</a>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        <a href="graficos.php" class="btn btn-info">Ver Gráficos</a>
    </div>
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
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['UsuarioID'] ?></td>
                <td><?= $row['NombreUsuario'] ?></td>
                <td><?= $row['Email'] ?></td>
                <td><?= $row['NombreRol'] ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $row['UsuarioID'] ?>" class="btn btn-primary btn-sm">Editar</a>
                    <a href="delete_user.php?id=<?= $row['UsuarioID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$result->free();
$conn->close();
?>