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

// Consulta para contar proveedores por reputación
$queryReputacion = "SELECT Reputacion, COUNT(ProveedorID) as Cantidad 
                    FROM proveedores 
                    GROUP BY Reputacion";

$resultReputacion = $conn->query($queryReputacion);

if (!$resultReputacion) {
    die("Error en la consulta de reputación: " . $conn->error);
}

// Extraer datos para el gráfico
$reputaciones = [];
$cantidades = [];

while ($row = $resultReputacion->fetch_assoc()) {
    $reputaciones[] = $row['Reputacion'];
    $cantidades[] = $row['Cantidad'];
}

$resultReputacion->free();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos de Proveedores</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center">Gráficos de Proveedores por Reputación</h3>
    <div class="row">
        <!-- Gráfico de Pastel -->
        <div class="col-md-6">
            <canvas id="reputacionPieChart"></canvas>
        </div>

        <!-- Gráfico de Barras -->
        <div class="col-md-6">
            <canvas id="reputacionBarChart"></canvas>
        </div>
    </div>

    <!-- Botón para volver al dashboard -->
    <div class="mt-4 text-center">
        <a href="dashboard_proveedores.php" class="btn btn-primary">Volver al Listado</a>
    </div>
</div>

<script>
    const reputaciones = <?= json_encode($reputaciones) ?>;
    const cantidades = <?= json_encode($cantidades) ?>;

    // Gráfico de Pastel
    const pieCtx = document.getElementById('reputacionPieChart').getContext('2d');
    const reputacionPieChart = new Chart(pieCtx, {
        type: 'pie',  // Tipo de gráfico de pastel
        data: {
            labels: reputaciones,
            datasets: [{
                label: 'Cantidad de Proveedores por Reputación',
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
    const barCtx = document.getElementById('reputacionBarChart').getContext('2d');
    const reputacionBarChart = new Chart(barCtx, {
        type: 'bar',  // Tipo de gráfico de barras
        data: {
            labels: reputaciones,
            datasets: [{
                label: 'Cantidad de Proveedores por Reputación',
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
