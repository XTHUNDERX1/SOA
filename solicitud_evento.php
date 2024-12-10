<?php
// conexión a la base de datos
include 'connect.php';

// Función para procesar una solicitud de evento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['procesar_evento'])) {
        // Procesar evento: registrar en la base de datos
        $tipoEvento = mysqli_real_escape_string($conn, $_POST['tipoEvento']);
        $fecha = mysqli_real_escape_string($conn, $_POST['fecha']);
        $lugar = mysqli_real_escape_string($conn, $_POST['lugar']);
        $clienteID = (int) $_POST['clienteID'];
        $proveedorID = (int) $_POST['proveedorID'];

        // Sentencia preparada para insertar el evento
        $query = $conn->prepare("INSERT INTO eventos (TipoEvento, Fecha, Lugar, ClienteID, ProveedorID) 
                                 VALUES (?, ?, ?, ?, ?)");
        $query->bind_param("sssii", $tipoEvento, $fecha, $lugar, $clienteID, $proveedorID);

        if ($query->execute()) {
            echo "<p>El evento se ha procesado correctamente.</p>";
            $eventoID = $conn->insert_id; // Obtener el ID del evento registrado
        } else {
            echo "<p>Error al procesar el evento: " . $conn->error . "</p>";
        }
    }

    if (isset($_POST['finalizar_evento'])) {
        // Finalizar evento
        $eventoID = (int) $_POST['eventoID'];

        // Actualizar el evento para marcarlo como finalizado
        $query = $conn->prepare("UPDATE eventos SET Estado = 'Finalizado' WHERE EventoID = ?");
        $query->bind_param("i", $eventoID);

        if ($query->execute()) {
            echo "<p>El evento ha sido finalizado.</p>";
            $mostrarFeedbackForm = true;
        } else {
            echo "<p>Error al finalizar el evento: " . $conn->error . "</p>";
        }
    }

    if (isset($_POST['guardar_feedback'])) {
        // Guardar feedback
        $eventoID = (int) $_POST['eventoID'];
        $comentarios = mysqli_real_escape_string($conn, $_POST['comentarios']);
        $calificacion = (int) $_POST['calificacion'];

        // Sentencia preparada para insertar el feedback
        $query = $conn->prepare("INSERT INTO feedback (EventoID, Comentarios, Calificacion) 
                                 VALUES (?, ?, ?)");
        $query->bind_param("isi", $eventoID, $comentarios, $calificacion);

        if ($query->execute()) {
            echo "<p>Gracias por tu feedback. El proceso ha finalizado.</p>";
        } else {
            echo "<p>Error al guardar el feedback: " . $conn->error . "</p>";
        }
    }

    if (isset($_POST['finalizar_sin_feedback'])) {
        // Finalizar sin feedback
        echo "<p>El proceso ha sido finalizado sin dejar feedback.</p>";
    }
}
?>
