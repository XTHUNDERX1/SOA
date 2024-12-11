<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es un administrador
if (!isset($_SESSION['UsuarioID']) || $_SESSION['RolID'] != 2) {
    header('Location: user_home.html');
    exit();
}

include 'connect.php'; // Incluir la conexión a la base de datos

// Verificar si se pasa un ID de evento a través de la URL
if (isset($_GET['id'])) {
    $eventoID = $_GET['id'];

    // Consultar el evento por su ID
    $query = "SELECT * FROM eventos WHERE EventoID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $eventoID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $evento = $result->fetch_assoc();
    } else {
        echo "Evento no encontrado.";
        exit();
    }
} else {
    echo "ID de evento no proporcionado.";
    exit();
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipoEvento = $_POST['TipoEvento'];
    $fecha = $_POST['Fecha'];
    $lugar = $_POST['Lugar'];
    $clienteID = $_POST['ClienteID'];
    $proveedorID = $_POST['ProveedorID'];

    // Actualizar el evento en la base de datos
    $updateQuery = "UPDATE eventos SET TipoEvento = ?, Fecha = ?, Lugar = ?, ClienteID = ?, ProveedorID = ? WHERE EventoID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('sssiii', $tipoEvento, $fecha, $lugar, $clienteID, $proveedorID, $eventoID);
    
    if ($stmt->execute()) {
        header('Location: dashboard_eventos.php'); // Redirigir a la lista de eventos
        exit();
    } else {
        echo "Error al actualizar el evento.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Evento</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Evento</h2>
        <form method="POST">
            <div class="form-group">
                <label for="TipoEvento">Tipo de Evento</label>
                <input type="text" class="form-control" id="TipoEvento" name="TipoEvento" value="<?= $evento['TipoEvento'] ?>" required>
            </div>
            <div class="form-group">
                <label for="Fecha">Fecha</label>
                <input type="date" class="form-control" id="Fecha" name="Fecha" value="<?= $evento['Fecha'] ?>" required>
            </div>
            <div class="form-group">
                <label for="Lugar">Lugar</label>
                <input type="text" class="form-control" id="Lugar" name="Lugar" value="<?= $evento['Lugar'] ?>" required>
            </div>
            <div class="form-group">
                <label for="ClienteID">Cliente</label>
                <select class="form-control" id="ClienteID" name="ClienteID">
                    <option value="">Seleccione un Cliente</option>
                    <?php
                    // Obtener los clientes
                    $clientesQuery = "SELECT ClienteID, NombreCliente FROM clientes";
                    $clientesResult = $conn->query($clientesQuery);
                    while ($cliente = $clientesResult->fetch_assoc()) {
                        echo "<option value='" . $cliente['ClienteID'] . "' " . ($evento['ClienteID'] == $cliente['ClienteID'] ? 'selected' : '') . ">" . $cliente['NombreCliente'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="ProveedorID">Proveedor</label>
                <select class="form-control" id="ProveedorID" name="ProveedorID">
                    <option value="">Seleccione un Proveedor</option>
                    <?php
                    // Obtener los proveedores
                    $proveedoresQuery = "SELECT ProveedorID, NombreProveedor FROM proveedores";
                    $proveedoresResult = $conn->query($proveedoresQuery);
                    while ($proveedor = $proveedoresResult->fetch_assoc()) {
                        echo "<option value='" . $proveedor['ProveedorID'] . "' " . ($evento['ProveedorID'] == $proveedor['ProveedorID'] ? 'selected' : '') . ">" . $proveedor['NombreProveedor'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="dashboard_eventos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
