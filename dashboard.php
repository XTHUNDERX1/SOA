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

// Consulta para contar usuarios por rol
$queryRoles = "SELECT r.NombreRol, COUNT(u.UsuarioID) as Cantidad 
               FROM Usuarios u 
               INNER JOIN roles r ON u.RolID = r.RolID 
               GROUP BY r.NombreRol";

$resultRoles = $conn->query($queryRoles);

if (!$resultRoles) {
    die("Error en la consulta de roles: " . $conn->error);
}

// Extraer datos para el gráfico
$roles = [];
$cantidades = [];

while ($row = $resultRoles->fetch_assoc()) {
    $roles[] = $row['NombreRol'];
    $cantidades[] = $row['Cantidad'];
}

$resultRoles->free();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuarios</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Lista de Usuarios</h2>
        <div class="d-flex justify-content-end mb-3">
            <a href="registro.html" class="btn btn-success">Agregar Nuevo Usuario</a>
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

        <!-- Gráfico circular -->
        <div class="mt-5">
            <h3 class="text-center">Grafico de Usuarios por Roles</h3>
            <canvas id="rolesChart" width="150" height="150"></canvas>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Datos para el gráfico
        const roles = <?= json_encode($roles) ?>;
        const cantidades = <?= json_encode($cantidades) ?>;

        // Crear gráfico circular con Chart.js
        const ctx = document.getElementById('rolesChart').getContext('2d');
        const rolesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: roles,
                datasets: [{
                    label: 'Cantidad de Usuarios por Rol',
                    data: cantidades,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
// Liberar resultados y cerrar conexión
$result->free();
$conn->close();
?>
