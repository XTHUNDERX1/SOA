<?php
// Asegúrate de que la conexión es correcta con PDO
$servername = "127.0.0.1";
$username = "u855900840_william";
$password = "SOA@utp123";
$dbname = "u855900840_eventos_peru";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Verificación de la conexión
} catch(PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
    exit;
}

// Consulta de usuarios
$query = "SELECT UsuarioID, NombreUsuario, Email, NombreRol FROM Usuarios INNER JOIN roles ON Usuarios.RolID = roles.RolID";
try {
    // Ejecutar la consulta
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Comprobar si hay resultados
    if (empty($result)) {
        echo "<div class='alert alert-warning' role='alert'>No se encontraron usuarios.</div>";
    } else {
        // Mostrar los resultados con un diseño de Bootstrap
        echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Panel de Usuarios</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>
    <div class='container mt-5'>
        <h2 class='text-center mb-4'>Lista de Usuarios</h2>
        <div class='d-flex justify-content-end mb-3'>
            <a href='registro.html' class='btn btn-success'>Agregar Nuevo Usuario</a>
        </div>
        <table class='table table-bordered table-striped'>
            <thead class='thead-dark'>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>";

        foreach ($result as $row) {
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

        echo "</tbody></table></div>";

        // Scripts de Bootstrap JS y dependencias
        echo "<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js'></script>
        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
</body>
</html>";
    }
} catch(PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Error en la consulta: " . $e->getMessage() . "</div>";
}
?>
