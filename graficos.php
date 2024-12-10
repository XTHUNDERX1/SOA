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
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos de Usuarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center">Gráficos de Usuarios por Roles</h3>
    <div class="row">
        <!-- Gráfico de Pastel -->
        <div class="col-md-6">
            <canvas id="rolesPieChart"></canvas>
        </div>

        <!-- Gráfico de Barras -->
        <div class="col-md-6">
            <canvas id="rolesBarChart"></canvas>
        </div>
    </div>
</div>

<script>
    const roles = <?= json_encode($roles) ?>;
    const cantidades = <?= json_encode($cantidades) ?>;

    // Gráfico de Pastel
    const pieCtx = document.getElementById('rolesPieChart').getContext('2d');
    const rolesPieChart = new Chart(pieCtx, {
        type: 'pie',  // Tipo de gráfico de pastel
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

    // Gráfico de Barras
    const barCtx = document.getElementById('rolesBarChart').getContext('2d');
    const rolesBarChart = new Chart(barCtx, {
        type: 'bar',  // Tipo de gráfico de barras
        data: {
            labels: roles,
            datasets: [{
                label: 'Cantidad de Usuarios por Rol',
                data: cantidades,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',  // Color de las barras
                borderColor: 'rgba(75, 192, 192, 1)',  // Color del borde de las barras
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
            },
            scales: {
                y: {
                    beginAtZero: true  // Asegura que las barras comiencen desde cero en el eje Y
                }
            }
        }
    });
</script>
</body>
</html>
