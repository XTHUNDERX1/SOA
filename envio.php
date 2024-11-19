<?php
// Asegúrate de que la conexión es correcta con mysqli
$servername = "127.0.0.1";
$username = "u855900840_william";
$password = "SOA@utp123";
$dbname = "u855900840_eventos_peru";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$evento_id = $_POST['evento_id'];
$comentarios = $_POST['comentarios'];
$calificacion = $_POST['calificacion'];

// Validar que la calificación esté en el rango de 1 a 5
if ($calificacion < 1 || $calificacion > 5) {
    echo "La calificación debe estar entre 1 y 5.";
    exit;
}

// Preparar la consulta SQL
$sql = "INSERT INTO feedback (EventoID, Comentarios, Calificacion) VALUES (?, ?, ?)";

// Preparar la sentencia
if ($stmt = $conn->prepare($sql)) {
    // Vincular los parámetros
    $stmt->bind_param("isi", $evento_id, $comentarios, $calificacion); // "i" para entero, "s" para string
    
    // Ejecutar la declaración
    if ($stmt->execute()) {
        // Preparar el mensaje del correo
        $subject = "Nuevo Feedback para Evento ID: $evento_id";
        $message = "Se ha recibido un nuevo feedback para el evento con ID: $evento_id.\n\n";
        $message .= "Comentarios: $comentarios\n";
        $message .= "Calificación: $calificacion\n";

        // Cabeceras del correo
        $headers = "From: marengo_2013@hotmail.com\r\n"; // Cambia a tu dominio o correo desde el que se enviará
        $headers .= "Reply-To: $comentarios\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Enviar el correo
        if (mail("william220418@gmail.com", $subject, $message, $headers)) {
            echo "El correo fue enviado correctamente.";
        } else {
            echo "Error al enviar el correo.";
        }

        // Redirigir al usuario después de un envío exitoso
        header("Location: user_home.html");
        exit; // Importante para detener la ejecución del script después de la redirección
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }

    // Cerrar la sentencia
    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
