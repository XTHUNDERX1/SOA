<?php
// conexión a la base de datos
include 'connect.php';

// Función para procesar una solicitud de evento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['procesar_evento'])) {
        // Procesar evento: registrar en la base de datos
        $tipoEvento = $_POST['tipo_evento'];
        $fecha = $_POST['fecha'];
        $lugar = $_POST['lugar'];
        $clienteID = $_POST['cliente_id'];
        $proveedorID = $_POST['proveedor_id'];

        $query = "INSERT INTO eventos (TipoEvento, Fecha, Lugar, ClienteID, ProveedorID) 
                  VALUES ('$tipoEvento', '$fecha', '$lugar', $clienteID, $proveedorID)";
        if (mysqli_query($conn, $query)) {
            echo "<p>El evento se ha procesado correctamente.</p>";
            $eventoID = mysqli_insert_id($conn); // Obtener el ID del evento registrado
        } else {
            echo "<p>Error al procesar el evento: " . mysqli_error($conn) . "</p>";
        }
    }

    if (isset($_POST['finalizar_evento'])) {
        // Finalizar evento
        $eventoID = $_POST['evento_id'];

        $query = "UPDATE eventos SET Fecha = Fecha WHERE EventoID = $eventoID"; // Simulación de finalización
        if (mysqli_query($conn, $query)) {
            echo "<p>El evento ha sido finalizado.</p>";
            $mostrarFeedbackForm = true;
        } else {
            echo "<p>Error al finalizar el evento: " . mysqli_error($conn) . "</p>";
        }
    }

    if (isset($_POST['guardar_feedback'])) {
        // Guardar feedback
        $eventoID = $_POST['evento_id'];
        $comentarios = $_POST['comentarios'];
        $calificacion = $_POST['calificacion'];

        $query = "INSERT INTO feedback (EventoID, Comentarios, Calificacion) 
                  VALUES ($eventoID, '$comentarios', $calificacion)";
        if (mysqli_query($conn, $query)) {
            echo "<p>Gracias por tu feedback. El proceso ha finalizado.</p>";
        } else {
            echo "<p>Error al guardar el feedback: " . mysqli_error($conn) . "</p>";
        }
    }

    if (isset($_POST['finalizar_sin_feedback'])) {
        // Finalizar sin feedback
        echo "<p>El proceso ha sido finalizado sin dejar feedback.</p>";
    }
}
?>