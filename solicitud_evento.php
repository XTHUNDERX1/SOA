<?php
// Incluir la conexión a la base de datos
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se envió el formulario para registrar un evento
    if (isset($_POST['tipoEvento'], $_POST['fecha'], $_POST['lugar'], $_POST['clienteID'], $_POST['proveedorID'])) {
        // Obtener los valores del formulario
        $tipoEvento = mysqli_real_escape_string($conn, $_POST['tipoEvento']);
        $fecha = mysqli_real_escape_string($conn, $_POST['fecha']);
        $lugar = mysqli_real_escape_string($conn, $_POST['lugar']);
        $clienteID = (int) $_POST['clienteID'];
        $proveedorID = (int) $_POST['proveedorID'];

        // Insertar los datos en la tabla de eventos
        $query = $conn->prepare("INSERT INTO eventos (TipoEvento, Fecha, Lugar, ClienteID, ProveedorID) 
                                 VALUES (?, ?, ?, ?, ?)");
        $query->bind_param("sssii", $tipoEvento, $fecha, $lugar, $clienteID, $proveedorID);

        if ($query->execute()) {
            // Redirigir al dashboard de eventos después de registrar
            header("Location: dashboard_eventos.php");
            exit();
        } else {
            echo "<p>Error al procesar el evento: " . $conn->error . "</p>";
        }
    }
}
?>
