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

    // Eliminar el evento de la base de datos
    $deleteQuery = "DELETE FROM eventos WHERE EventoID = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param('i', $eventoID);
    
    if ($stmt->execute()) {
        header('Location: dashboard_eventos.php'); // Redirigir a la lista de eventos
        exit();
    } else {
        echo "Error al eliminar el evento.";
    }
} else {
    echo "ID de evento no proporcionado.";
    exit();
}
?>
