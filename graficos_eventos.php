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

// Consulta para obtener el conteo de eventos por tipo
$queryTipoEvento = "SELECT TipoEvento, COUNT(EventoID) as Cantidad FROM eventos GROUP BY TipoEvento";
$resultTipoEvento = $conn->query($queryTipoEvento);

// Consulta para obtener el conteo de eventos por cliente
$queryCliente = "SELECT c.NombreCliente, COUNT(e.EventoID) as Cantidad 
                 FROM eventos e 
                 LEFT JOIN clientes c ON e.ClienteID = c.ClienteID
                 GROUP BY c.NombreCliente";
$resultCliente = $conn->query($queryCliente);

// Extraer datos para los gráficos
$tiposEvento = [];
$cantidadesTipoEvento = [];
$clientes = [];
$cantidadesCliente = [];

while ($row = $resultTipoEvento->fetch_assoc()) {
    $tiposEvento[] = $row['TipoEvento'];
    $cantidadesTipoEvento[] = $row['Cantidad'];
}

while ($row = $resultCliente->fetch_assoc()) {
    $clientes[] = $row['NombreCliente'];
    $cantidadesCliente[] = $row['Cantidad'];
}

$resultTipoEvento->free();
$resultCliente->free();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos de Eventos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center">Gráficos de Eventos</h3>
    <div class="row">
        <!-- Gráfico de Pastel: Tipo de Evento -->
        <div class="col-md-6">
            <canvas id="tipoEventoPieChart"></canvas>
        </div>

        <!-- Gráfico de Barras: Eventos por Cliente -->
        <div class="col-md-6">
            <canvas id="eventoBarChart"></canvas>
        </div>
    </div>

    <!-- Botón para volver al dashboard -->
    <div class="mt-4 text-center">
        <a href="dashboard_eventos.php" class="btn btn-primary">Volver al Listado</a>
    </div>
</div>

<script>
    const tiposEvento = <?= json_encode($tiposEvento) ?>;
    const cantidadesTipoEvento = <?= json_encode($cantidadesTipoEvento) ?>;
    const clientes = <?= json_encode($clientes) ?>;
    const cantidadesCliente = <?= json_encode($cantidadesCliente) ?>;

    // Gráfico de Pastel: Tipo de Evento
    const pieCtx = document.getElementById('tipoEventoPieChart').getContext('2d');
    const tipoEventoPieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: tiposEvento,
            datasets: [{
                label: 'Cantidad de Eventos por Tipo',
                data: cantidadesTipoEvento,
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

    // Gráfico de Barras: Eventos por Cliente
    const barCtx = document.getElementById('eventoBarChart').getContext('2d');
    const eventoBarChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: clientes,
            datasets: [{
                label: 'Cantidad de Eventos por Cliente',
                data: cantidadesCliente,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
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
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>
